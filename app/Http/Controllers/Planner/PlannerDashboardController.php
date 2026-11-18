<?php

namespace App\Http\Controllers\Planner;

use App\Domains\Booking\Models\Booking;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Planning\Models\Task;
use App\Domains\Planning\Models\TimelineEvent;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PlannerDashboardController extends Controller
{
    /**
     * Display the Wedding Planner Portal dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Retrieve weddings where the planner is a member, or retrieve latest weddings for demo
        $managedWeddingIds = WeddingMember::where('user_id', $user->id)
            ->where('role', WeddingMemberRole::Planner)
            ->pluck('wedding_id');

        $clientWeddings = Wedding::whereIn('id', $managedWeddingIds)
            ->with(['owner', 'tasks', 'bookings.vendor', 'timelineEvents'])
            ->get();

        // If no specifically linked weddings yet, show available demo client weddings
        if ($clientWeddings->isEmpty()) {
            $clientWeddings = Wedding::with(['owner', 'tasks', 'bookings.vendor', 'timelineEvents'])
                ->latest()
                ->take(4)
                ->get();
        }

        // Aggregate statistics from real database records
        $activeClientsCount = $clientWeddings->count();
        $totalOverlookedBudget = (float) $clientWeddings->sum('total_budget');
        $totalBookingsCoordinated = Booking::whereIn('wedding_id', $clientWeddings->pluck('id'))->count();
        
        // Upcoming weddings sorted by date
        $upcomingWeddings = $clientWeddings->sortBy('wedding_date')->values();

        // Critical Nekath / Poruwa ceremonies timeline from client weddings
        $ceremoniesTimeline = TimelineEvent::whereIn('wedding_id', $clientWeddings->pluck('id'))
            ->with('wedding')
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->take(6)
            ->get();

        // Verified Vendors available for booking recommendation
        $preferredVendors = Vendor::with('category')
            ->where('is_featured', true)
            ->take(4)
            ->get();

        return view('planner.dashboard', compact(
            'user',
            'clientWeddings',
            'activeClientsCount',
            'totalOverlookedBudget',
            'totalBookingsCoordinated',
            'upcomingWeddings',
            'ceremoniesTimeline',
            'preferredVendors'
        ));
    }
}
