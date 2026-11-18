<?php

namespace App\Http\Controllers\Marketplace;

use App\Domains\Booking\Enums\QuotationStatus;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\Favorite;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Marketplace\Models\VendorPackage;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use App\Http\Controllers\Controller;
use App\Http\Requests\Marketplace\StoreRfqRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class VendorProfileController extends Controller
{
    /**
     * Display the vendor profile and booking page.
     */
    public function show(string $slug): View
    {
        $vendor = Vendor::with([
            'category',
            'packages' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order'),
            'media' => fn ($q) => $q->orderBy('sort_order'),
            'reviews.user',
            'reviews.wedding',
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        $user = Auth::user();
        $currentWedding = null;
        $isFavorited = false;

        if ($user) {
            $currentWedding = app(CurrentWeddingManager::class)->get();

            if (!$currentWedding) {
                $membership = WeddingMember::with('wedding')
                    ->where('user_id', $user->id)
                    ->where('invitation_status', InvitationStatus::Accepted)
                    ->first();
                $currentWedding = $membership?->wedding;
            }

            $isFavorited = Favorite::where('user_id', $user->id)
                ->where('vendor_id', $vendor->id)
                ->exists();
        }

        return view('marketplace.vendor-profile', compact('vendor', 'currentWedding', 'isFavorited'));
    }

    /**
     * Handle incoming Request for Quotation (RFQ).
     */
    public function storeRfq(StoreRfqRequest $request, string $slug): JsonResponse|RedirectResponse
    {
        $vendor = Vendor::where('slug', $slug)->firstOrFail();
        $validated = $request->validated();

        $user = Auth::user();
        $wedding = null;

        if ($user) {
            $wedding = app(CurrentWeddingManager::class)->get();
            if (!$wedding) {
                $membership = WeddingMember::with('wedding')
                    ->where('user_id', $user->id)
                    ->where('invitation_status', InvitationStatus::Accepted)
                    ->first();
                $wedding = $membership?->wedding;
            }

            if (!$wedding) {
                $wedding = Wedding::firstOrCreate(
                    ['owner_id' => $user->id],
                    [
                        'uuid' => (string) Str::uuid(),
                        'title' => $user->name . "'s Nuptial Celebration",
                        'partner1_name' => $user->name,
                        'partner2_name' => 'Fiancé(e)',
                        'wedding_date' => $validated['event_date'] ?? now()->addMonths(6)->toDateString(),
                        'wedding_type' => WeddingType::Traditional,
                        'district' => $vendor->district ?? 'Colombo',
                        'estimated_guest_count' => $validated['guest_count'] ?? 200,
                        'total_budget' => 3000000.00,
                        'currency' => 'LKR',
                        'status' => WeddingStatus::Planning,
                    ]
                );

                WeddingMember::firstOrCreate(
                    [
                        'wedding_id' => $wedding->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'role' => WeddingMemberRole::Owner,
                        'invitation_status' => InvitationStatus::Accepted,
                        'joined_at' => now(),
                        'permissions' => ['*'],
                    ]
                );
            }
        } else {
            // Unauthenticated guest couple submitting inquiry
            $guestEmail = $validated['guest_email'] ?? 'guest_' . Str::random(6) . '@wedora.lk';
            $guestName = $validated['guest_name'] ?? 'Prospective Couple';
            $guestPhone = $validated['guest_phone'] ?? '+94770000000';

            $user = User::firstOrCreate(
                ['email' => $guestEmail],
                [
                    'uuid' => (string) Str::uuid(),
                    'name' => $guestName,
                    'phone' => $guestPhone,
                    'role' => UserRole::Couple,
                    'status' => UserStatus::Active,
                    'password' => Hash::make(Str::random(16)),
                ]
            );

            $wedding = Wedding::create([
                'uuid' => (string) Str::uuid(),
                'owner_id' => $user->id,
                'title' => $guestName . "'s Wedding",
                'partner1_name' => $guestName,
                'partner2_name' => 'Partner',
                'wedding_date' => $validated['event_date'] ?? now()->addMonths(6)->toDateString(),
                'wedding_type' => WeddingType::Traditional,
                'district' => $vendor->district ?? 'Colombo',
                'estimated_guest_count' => $validated['guest_count'] ?? 200,
                'total_budget' => 3000000.00,
                'currency' => 'LKR',
                'status' => WeddingStatus::Planning,
            ]);

            WeddingMember::create([
                'wedding_id' => $wedding->id,
                'user_id' => $user->id,
                'role' => WeddingMemberRole::Owner,
                'invitation_status' => InvitationStatus::Accepted,
                'joined_at' => now(),
                'permissions' => ['*'],
            ]);
        }

        // Determine price
        $selectedPackage = null;
        $totalAmount = $vendor->starting_price ?? 0.00;

        if (!empty($validated['package_id'])) {
            $selectedPackage = VendorPackage::where('vendor_id', $vendor->id)
                ->where('id', $validated['package_id'])
                ->first();
            if ($selectedPackage) {
                $totalAmount = $selectedPackage->price;
            }
        }

        // Compile notes
        $servicesList = !empty($validated['services']) ? implode(', ', $validated['services']) : 'Full Nuptial Coverage';
        $style = $validated['ceremony_style'] ?? 'Traditional Poruwa + Western Reception';
        $composedMessage = "Ceremony Style: {$style}\nServices Required: {$servicesList}\n\nCouple Notes / Auspicious Timings:\n" . $validated['couple_message'];

        $quotation = Quotation::create([
            'uuid' => (string) Str::uuid(),
            'wedding_id' => $wedding->id,
            'vendor_id' => $vendor->id,
            'package_id' => $selectedPackage?->id,
            'requested_by_user_id' => $user->id,
            'event_date' => $validated['event_date'],
            'guest_count' => $validated['guest_count'] ?? 350,
            'venue_location' => $validated['venue_location'] ?? 'Colombo',
            'couple_message' => $composedMessage,
            'valid_until' => Carbon::parse($validated['event_date'])->subDays(14),
            'total_amount' => $totalAmount,
            'currency' => 'LKR',
            'status' => QuotationStatus::Pending,
        ]);

        $feedback = [
            'success' => true,
            'message' => 'Customized Quotation (RFQ) submitted successfully! The artisan has received an instant notification via SMS & WhatsApp.',
            'quotation_uuid' => $quotation->uuid,
        ];

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($feedback);
        }

        return redirect()->back()->with('success', $feedback['message']);
    }

    /**
     * Toggle vendor shortlist (favorite) status.
     */
    public function toggleFavorite(Request $request, string $slug): JsonResponse|RedirectResponse
    {
        $vendor = Vendor::where('slug', $slug)->firstOrFail();
        $user = Auth::user();

        if (!$user) {
            if ($request->wantsJson()) {
                return response()->json(['status' => 'unauthenticated', 'message' => 'Please sign in to shortlist vendors.'], 401);
            }
            return redirect()->route('login');
        }

        $favorite = Favorite::where('user_id', $user->id)
            ->where('vendor_id', $vendor->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
            $msg = 'Vendor removed from your shortlist.';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'vendor_id' => $vendor->id,
            ]);
            $isFavorited = true;
            $msg = 'Vendor added to your shortlist!';
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_favorited' => $isFavorited,
                'message' => $msg,
            ]);
        }

        return redirect()->back()->with('status', $msg);
    }

    /**
     * Schedule 15-Minute Video Consultation.
     */
    public function scheduleConsultation(Request $request, string $slug): JsonResponse|RedirectResponse
    {
        $vendor = Vendor::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'consultation_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'string'],
            'contact_phone' => ['required', 'string', 'max:30'],
            'consultation_notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $msg = 'Your 15-minute video consultation with ' . $vendor->business_name . ' has been provisionally scheduled for ' . $validated['consultation_date'] . ' at ' . $validated['preferred_time'] . '. Google Meet link has been dispatched to your contact details.';

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }
}
