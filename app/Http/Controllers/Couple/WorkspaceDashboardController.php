<?php

namespace App\Http\Controllers\Couple;

use App\Domains\Budget\Enums\PaymentStatus;
use App\Domains\Guest\Enums\RsvpStatus;
use App\Domains\Planning\Enums\TaskPriority;
use App\Domains\Planning\Enums\TaskStatus;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WorkspaceDashboardController extends Controller
{
    /**
     * Display couple workspace dashboard.
     */
    public function index(CurrentWeddingManager $manager): View
    {
        $wedding = $manager->get();
        $user = Auth::user();

        // Load relations
        $wedding->load([
            'members.user.profile',
            'invitations' => fn($q) => $q->where('status', InvitationStatus::Pending),
            'tasks.category',
            'tasks.assignedTo',
            'timelineEvents' => fn($q) => $q->orderBy('sort_order')->orderBy('start_time'),
            'budgets',
            'expenses',
            'guests',
        ]);

        $weddingDate = $wedding->wedding_date ? Carbon::parse($wedding->wedding_date) : Carbon::now()->addMonths(6);
        $now = Carbon::now();
        $daysRemaining = (int) ceil($now->diffInDays($weddingDate, false));

        // Task statistics directly from database
        $dbTasksCount = $wedding->tasks->count();
        $dbCompletedTasks = $wedding->tasks->where('status', TaskStatus::Completed)->count();
        $totalTasks = $dbTasksCount;
        $completedTasks = $dbCompletedTasks;
        $checklistProgress = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;

        // Partner details
        $ownerMember = $wedding->members->firstWhere('role', WeddingMemberRole::Owner);
        $partnerMember = $wedding->members->firstWhere('role', WeddingMemberRole::Partner);
        $collaboratorsCount = $wedding->members->where('role', WeddingMemberRole::Collaborator)->count();
        $pendingInvitesCount = $wedding->invitations->count();

        // Check if current user is owner or partner
        $userMember = $wedding->members->firstWhere('user_id', $user->id);
        $canManage = in_array($userMember?->role, [WeddingMemberRole::Owner, WeddingMemberRole::Partner]);

        // Budget calculations from real records
        $totalBudget = (float) ($wedding->total_budget ?? 0);
        $spentBudget = (float) $wedding->expenses->sum('actual_cost');
        $remainingBudget = max(0, $totalBudget - $spentBudget);
        $budgetProgress = $totalBudget > 0 ? (int) round(($spentBudget / $totalBudget) * 100) : 0;

        // Guest RSVPs from real records
        $totalGuestsInvited = (int) ($wedding->estimated_guest_count ?: $wedding->guests->count());
        $attendingCount = $wedding->guests->where('rsvp_status', RsvpStatus::Attending)->count();
        $pendingRsvpCount = $wedding->guests->where('rsvp_status', RsvpStatus::Pending)->count();
        $declinedCount = $wedding->guests->where('rsvp_status', RsvpStatus::Declined)->count();
        $confirmedRate = $totalGuestsInvited > 0 ? (int) round(($attendingCount / $totalGuestsInvited) * 100) : 0;

        // Real Timeline Events
        $nekathTimeline = $wedding->timelineEvents;

        // Poruwa Nekath from real timeline
        $poruwaNekathEvent = $nekathTimeline->first(function ($e) {
            return stripos($e->title, 'poruwa') !== false || stripos($e->title, 'nekath') !== false;
        }) ?? $nekathTimeline->first();

        $poruwaNekath = $poruwaNekathEvent ? [
            'time' => Carbon::parse($poruwaNekathEvent->start_time)->format('h:i A'),
            'title' => $poruwaNekathEvent->title,
            'astrologer' => $poruwaNekathEvent->description ?: 'Astrological Timing Synchronized',
            'status' => 'Astrological Alignment Locked',
        ] : null;

        // Urgent Milestone from real pending tasks
        $urgentTask = $wedding->tasks
            ->where('status', '!=', TaskStatus::Completed)
            ->sortBy('due_date')
            ->first();

        $urgentMilestone = $urgentTask ? [
            'title' => $urgentTask->title,
            'description' => $urgentTask->description ?: ($urgentTask->category?->name ?? 'Wedding Priority Milestone'),
            'due_in' => $urgentTask->due_date ? Carbon::parse($urgentTask->due_date)->diffForHumans() : 'Upcoming',
            'priority' => ucfirst($urgentTask->priority->value ?? 'High') . ' Priority',
        ] : null;

        // Real tasks list
        $tasksList = $wedding->tasks->sortBy('sort_order')->values();

        // Real Council Members
        $councilMembers = $wedding->members;

        return view('couple.dashboard', [
            'wedding' => $wedding,
            'user' => $user,
            'weddingDate' => $weddingDate,
            'daysRemaining' => $daysRemaining,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'checklistProgress' => $checklistProgress,
            'ownerMember' => $ownerMember,
            'partnerMember' => $partnerMember,
            'collaboratorsCount' => $collaboratorsCount,
            'pendingInvitesCount' => $pendingInvitesCount,
            'canManage' => $canManage,
            'totalBudget' => $totalBudget,
            'spentBudget' => $spentBudget,
            'remainingBudget' => $remainingBudget,
            'budgetProgress' => $budgetProgress,
            'totalGuestsInvited' => $totalGuestsInvited,
            'attendingCount' => $attendingCount,
            'pendingRsvpCount' => $pendingRsvpCount,
            'declinedCount' => $declinedCount,
            'confirmedRate' => $confirmedRate,
            'poruwaNekath' => $poruwaNekath,
            'urgentMilestone' => $urgentMilestone,
            'tasksList' => $tasksList,
            'nekathTimeline' => $nekathTimeline,
            'councilMembers' => $councilMembers,
        ]);
    }
}
