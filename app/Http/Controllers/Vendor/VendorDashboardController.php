<?php

namespace App\Http\Controllers\Vendor;

use App\Domains\Booking\Enums\BookingStatus;
use App\Domains\Booking\Enums\QuotationStatus;
use App\Domains\Booking\Models\Booking;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Booking\Models\Review;
use App\Domains\Marketplace\Enums\VerificationStatus;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Marketplace\Models\VendorCategory;
use App\Domains\Marketplace\Models\VendorPackage;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VendorDashboardController extends Controller
{
    /**
     * Display the Vendor Business & Atelier Dashboard.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $isDemoPreview = false;

        // 1. Determine active vendor
        if ($user && $user->isVendor()) {
            $vendor = Vendor::where('user_id', $user->id)
                ->with(['category', 'packages', 'media', 'reviews'])
                ->first();
        } else {
            $vendor = null;
            $isDemoPreview = true;
        }

        if (!$vendor) {
            $vendor = Vendor::with(['category', 'packages', 'media', 'reviews'])->first();
        }

        // 2. Compute dynamic metrics directly from database
        $inquiriesCount = $vendor ? Quotation::where('vendor_id', $vendor->id)->count() : 0;
        $pendingInquiries = $vendor ? Quotation::where('vendor_id', $vendor->id)->where('status', QuotationStatus::Pending)->count() : 0;
        $confirmedBookingsCount = $vendor ? Booking::where('vendor_id', $vendor->id)->where('status', BookingStatus::Confirmed)->count() : 0;

        $dbEarnings = $vendor ? (Booking::where('vendor_id', $vendor->id)->whereIn('status', [BookingStatus::Confirmed, BookingStatus::Completed])->sum('total_amount') ?? 0.00) : 0.00;
        $totalBookedRevenue = (float) $dbEarnings;
        $escrowCleared = $vendor ? (float) (Booking::where('vendor_id', $vendor->id)->where('status', BookingStatus::Completed)->sum('total_amount') ?? 0.00) : 0.00;
        $averageDealSize = $confirmedBookingsCount > 0 ? (float) round($totalBookedRevenue / $confirmedBookingsCount, 2) : 0.00;

        // 3. Query Recent Quotations / Pipeline Leads
        $recentQuotations = $vendor ? Quotation::where('vendor_id', $vendor->id)
            ->with(['wedding', 'package', 'requestedBy'])
            ->latest()
            ->take(6)
            ->get() : collect();

        // 4. Imminent / Upcoming Booking & Recent Transactions
        $upcomingBooking = $vendor ? Booking::where('vendor_id', $vendor->id)
            ->whereIn('status', [BookingStatus::Confirmed, BookingStatus::Completed])
            ->where('event_date', '>=', now()->toDateString())
            ->with(['wedding.timelineEvents', 'package'])
            ->orderBy('event_date')
            ->first() : null;

        if (!$upcomingBooking && $vendor) {
            $upcomingBooking = Booking::where('vendor_id', $vendor->id)
                ->with(['wedding.timelineEvents', 'package'])
                ->latest('event_date')
                ->first();
        }

        $recentBookings = $vendor ? Booking::where('vendor_id', $vendor->id)
            ->with(['wedding', 'package'])
            ->latest()
            ->take(5)
            ->get() : collect();

        // 5. Packages & Reviews
        $packages = $vendor ? VendorPackage::where('vendor_id', $vendor->id)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get() : collect();

        $reviews = $vendor ? Review::where('vendor_id', $vendor->id)
            ->with('wedding')
            ->latest()
            ->take(5)
            ->get() : collect();

        return view('vendor.dashboard', compact(
            'vendor',
            'inquiriesCount',
            'pendingInquiries',
            'confirmedBookingsCount',
            'totalBookedRevenue',
            'escrowCleared',
            'averageDealSize',
            'recentQuotations',
            'upcomingBooking',
            'recentBookings',
            'packages',
            'reviews',
            'isDemoPreview'
        ));
    }

    /**
     * Download or view crew briefing PDF / text.
     */
    public function downloadCrewBrief(Request $request): JsonResponse|RedirectResponse
    {
        $user = Auth::user();
        $vendor = ($user && $user->isVendor()) ? Vendor::where('user_id', $user->id)->first() : null;
        if (!$vendor) {
            $vendor = Vendor::first();
        }

        $booking = $vendor ? Booking::where('vendor_id', $vendor->id)
            ->with(['wedding.timelineEvents', 'package'])
            ->latest('event_date')
            ->first() : null;

        $wedding = $booking?->wedding;

        $brief = [
            'wedding' => $wedding ? ($wedding->partner1_name . ' & ' . $wedding->partner2_name) : 'Private Nuptials',
            'date' => $booking?->event_date ? Carbon::parse($booking->event_date)->format('F d, Y') : 'Date to be scheduled',
            'venue' => $wedding?->location ?: 'Client Designated Venue',
            'call_time' => '07:30 AM (Dress: Studio Black)',
            'crew' => [
                'Director / Lead' => ($vendor?->business_name ?? 'Studio Lead') . ' (Primary Camera Rig)',
                'Second Associate' => 'Studio Team Member (4K Secondary Body)',
                'Drone / Aerial' => 'Certified Pilot (4K Aerial Coverage)',
            ],
            'nekath_chronology' => ($wedding && $wedding->timelineEvents->isNotEmpty())
                ? $wedding->timelineEvents->map(fn($e) => [
                    'time' => Carbon::parse($e->start_time)->format('h:i A'),
                    'event' => $e->title,
                ])->toArray()
                : [
                    ['time' => '07:30 AM', 'event' => 'Bridal Suite Prep & Groom Mul Anduma Draping'],
                    ['time' => '09:42 AM', 'event' => 'Auspicious Ascent to Poruwa (Facing East)'],
                    ['time' => '09:55 AM', 'event' => 'Nuul Bandheema & Ring Exchange Ceremony'],
                    ['time' => '10:20 AM', 'event' => 'Descent & Breaking of Pol Coconut'],
                ],
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'brief' => $brief,
                'message' => 'Crew briefing generated successfully.',
            ]);
        }

        return redirect()->back()->with('success', 'Crew briefing protocol generated and ready for print dispatch.');
    }
}
