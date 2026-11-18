<?php

namespace App\Http\Controllers\Admin;

use App\Domains\Booking\Models\Booking;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Marketplace\Models\VendorCategory;
use App\Domains\Platform\Models\SubscriptionPlan;
use App\Domains\Wedding\Models\Wedding;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the Super Admin Control Center dashboard.
     */
    public function index(): View
    {
        // Core Platform Metrics
        $totalCouples = User::where('role', UserRole::Couple)->count();
        $totalVendors = User::where('role', UserRole::Vendor)->count();
        $totalPlanners = User::where('role', UserRole::Planner)->count();
        $totalWeddings = Wedding::count();
        
        // Financial & Booking Volumes
        $totalBookings = Booking::count();
        $grossBookingValue = Booking::sum('total_amount') ?? 0.00;
        $totalQuotations = Quotation::count();

        // Vendor Directory Status
        $vendors = Vendor::with(['category', 'user'])->latest()->take(6)->get();
        $pendingVerificationCount = Vendor::where('verification_status', 'pending')->count();

        // Recent Registered Weddings
        $recentWeddings = Wedding::with('owner')->latest()->take(5)->get();

        // Subscription Tiers
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('sort_order')->get();

        // System Diagnostic Metrics
        $systemInfo = [
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
            'database' => config('database.default'),
            'database_name' => config('database.connections.mysql.database'),
            'server_environment' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
        ];

        return view('admin.dashboard', compact(
            'totalCouples',
            'totalVendors',
            'totalPlanners',
            'totalWeddings',
            'totalBookings',
            'grossBookingValue',
            'totalQuotations',
            'vendors',
            'pendingVerificationCount',
            'recentWeddings',
            'plans',
            'systemInfo'
        ));
    }
}
