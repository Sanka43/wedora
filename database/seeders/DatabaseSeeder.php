<?php

namespace Database\Seeders;

use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VendorCategorySeeder::class,
            SriLankaDistrictsSeeder::class,
            ChecklistTemplateSeeder::class,
            SubscriptionPlanSeeder::class,
        ]);

        // Seed default Super Admin and demo couple
        User::firstOrCreate(
            ['email' => 'admin@wedora.lk'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Wedora Super Admin',
                'password' => Hash::make('Wedora@2026'),
                'phone' => '+94771234567',
                'role' => UserRole::SuperAdmin,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'couple@example.com'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Kasun & Dilani',
                'password' => Hash::make('password'),
                'phone' => '+94779876543',
                'role' => UserRole::Couple,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );
    }
}
