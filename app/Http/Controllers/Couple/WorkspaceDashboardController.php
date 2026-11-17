<?php

namespace App\Http\Controllers\Couple;

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

        // Load members with profiles
        $wedding->load([
            'members.user.profile',
            'invitations' => fn($q) => $q->where('status', InvitationStatus::Pending),
            'tasks',
        ]);

        $weddingDate = Carbon::parse($wedding->wedding_date);
        $now = Carbon::now();
        $daysRemaining = (int) ceil($now->diffInDays($weddingDate, false));

        // Task statistics
        $totalTasks = $wedding->tasks->count();
        $completedTasks = $wedding->tasks->where('status', TaskStatus::Completed)->count();
        $checklistProgress = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;

        // Partner details
        $ownerMember = $wedding->members->firstWhere('role', WeddingMemberRole::Owner);
        $partnerMember = $wedding->members->firstWhere('role', WeddingMemberRole::Partner);
        $collaboratorsCount = $wedding->members->where('role', WeddingMemberRole::Collaborator)->count();
        $pendingInvitesCount = $wedding->invitations->count();

        // Check if current user is owner or partner
        $userMember = $wedding->members->firstWhere('user_id', $user->id);
        $canManage = in_array($userMember?->role, [WeddingMemberRole::Owner, WeddingMemberRole::Partner]);

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
        ]);
    }
}
