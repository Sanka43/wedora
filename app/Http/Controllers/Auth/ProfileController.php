<?php

namespace App\Http\Controllers\Auth;

use App\Domains\Marketplace\Enums\VerificationStatus;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Marketplace\Models\VendorCategory;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Models\WeddingMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display role-based user profile.
     */
    public function show(): View
    {
        $user = Auth::user()->load(['profile', 'vendor.category']);

        $districts = [
            'Colombo', 'Gampaha', 'Kalutara', 'Kandy', 'Matale', 'Nuwara Eliya',
            'Galle', 'Matara', 'Hambantota', 'Jaffna', 'Kilinochchi', 'Mannar',
            'Vavuniya', 'Mullaitivu', 'Batticaloa', 'Ampara', 'Trincomalee',
            'Kurunegala', 'Puttalam', 'Anuradhapura', 'Polonnaruwa', 'Badulla',
            'Monaragala', 'Ratnapura', 'Kegalle'
        ];

        $categories = VendorCategory::where('is_active', true)->orderBy('sort_order')->get();

        $plannerSpecializations = [
            'Traditional Poruwa Ceremonies',
            'Kandyan Royal Nuptials',
            'Low-Country & Southern Customs',
            'Catholic & Christian Church Nuptials',
            'Tamil Hindu Ceremonies',
            'Luxury Ballroom & Gala Receptions',
            'Destination Island Weddings',
            'Eco-Chic & Heritage Estate Celebrations',
            'Nekath Chronology & Ritual Alignment',
        ];

        $managedWeddingsCount = 0;
        if ($user->isPlanner()) {
            $managedWeddingsCount = WeddingMember::where('user_id', $user->id)
                ->where('role', WeddingMemberRole::Planner)
                ->count();
        }

        $activeWedding = null;
        if ($user->isCouple()) {
            $activeWedding = $user->ownedWeddings()->first() ?? $user->weddings()->first();
        }

        return view('auth.profile', compact(
            'user',
            'districts',
            'categories',
            'plannerSpecializations',
            'managedWeddingsCount',
            'activeWedding'
        ));
    }

    /**
     * Update role-based user profile information.
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $validated = $request->validated();

        // 1. Update Core User Details
        $user->update([
            'name' => $validated['name'],
            'email' => strtolower(trim($validated['email'])),
            'phone' => $validated['phone'] ?? null,
        ]);

        // 2. Role-specific profile delegation
        if ($user->isVendor()) {
            $vendorData = [
                'business_name' => $validated['business_name'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'],
                'district' => $validated['district'],
                'address' => $validated['address'],
                'phone' => $validated['vendor_phone'] ?? $validated['phone'] ?? '+94770000000',
                'email' => $validated['vendor_email'] ?? $validated['email'],
                'website' => $validated['website'] ?? null,
                'instagram_handle' => $validated['instagram_handle'] ?? null,
                'facebook_url' => $validated['facebook_url'] ?? null,
                'starting_price' => $validated['starting_price'] ?? null,
            ];

            $vendor = $user->vendor;
            if ($vendor) {
                $vendor->update($vendorData);
            } else {
                $vendorData['uuid'] = (string) Str::uuid();
                $vendorData['user_id'] = $user->id;
                $vendorData['slug'] = Str::slug($validated['business_name']) . '-' . Str::lower(Str::random(4));
                $vendorData['verification_status'] = VerificationStatus::Pending;
                $vendorData['is_active'] = true;
                Vendor::create($vendorData);
            }

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'avatar_url' => $validated['avatar_url'] ?? null,
                    'preferred_locale' => $validated['preferred_locale'] ?? 'en',
                ]
            );
        } elseif ($user->isPlanner()) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $validated['company_name'],
                    'designation' => $validated['designation'] ?? null,
                    'bio' => $validated['bio'] ?? null,
                    'experience_years' => $validated['experience_years'] ?? null,
                    'specializations' => $validated['specializations'] ?? [],
                    'operating_districts' => $validated['operating_districts'] ?? [],
                    'website' => $validated['website'] ?? null,
                    'instagram_handle' => $validated['instagram_handle'] ?? null,
                    'facebook_url' => $validated['facebook_url'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'avatar_url' => $validated['avatar_url'] ?? null,
                    'preferred_locale' => $validated['preferred_locale'] ?? 'en',
                ]
            );
        } elseif ($user->isCouple()) {
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'partner_name' => $validated['partner_name'] ?? null,
                    'preferred_locale' => $validated['preferred_locale'] ?? 'en',
                    'avatar_url' => $validated['avatar_url'] ?? null,
                    'notification_preferences' => $validated['notification_preferences'] ?? null,
                ]
            );
        } else {
            // Super Admin
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'avatar_url' => $validated['avatar_url'] ?? null,
                    'preferred_locale' => $validated['preferred_locale'] ?? 'en',
                ]
            );
        }

        return back()->with('success', __('Your profile and credentials have been updated successfully.'));
    }
}
