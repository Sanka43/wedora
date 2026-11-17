<?php

namespace App\Domains\Identity\Actions;

use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Identity\Models\UserProfile;
use App\Domains\Marketplace\Enums\VerificationStatus;
use App\Domains\Marketplace\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterUserAction
{
    /**
     * Register a new user and initialize associated profile or vendor records.
     *
     * @param array<string, mixed> $data
     */
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $role = isset($data['role'])
                ? ($data['role'] instanceof UserRole ? $data['role'] : UserRole::from($data['role']))
                : UserRole::Couple;

            $user = User::create([
                'name' => $data['name'],
                'email' => strtolower(trim($data['email'])),
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'] ?? null,
                'role' => $role,
                'status' => UserStatus::Active,
            ]);

            UserProfile::create([
                'user_id' => $user->id,
                'partner_name' => $data['partner_name'] ?? null,
                'preferred_locale' => $data['preferred_locale'] ?? 'en',
                'notification_preferences' => [
                    'email_task_reminders' => true,
                    'email_budget_alerts' => true,
                    'email_collaborator_activity' => true,
                ],
            ]);

            if ($role === UserRole::Vendor && !empty($data['business_name'])) {
                $businessName = $data['business_name'];
                $baseSlug = Str::slug($businessName);
                $slug = $baseSlug;
                $counter = 1;
                while (Vendor::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }

                Vendor::create([
                    'user_id' => $user->id,
                    'category_id' => $data['category_id'] ?? null,
                    'business_name' => $businessName,
                    'slug' => $slug,
                    'description' => $data['description'] ?? ($businessName . ' - Verified Wedding Vendor on Wedora Sri Lanka'),
                    'address' => $data['address'] ?? ($data['district'] ?? 'Colombo'),
                    'district' => $data['district'] ?? 'Colombo',
                    'phone' => $data['phone'] ?? '+94 77 000 0000',
                    'email' => $data['email'],
                    'verification_status' => VerificationStatus::Pending,
                    'is_active' => true,
                ]);
            }

            return $user;
        });
    }
}
