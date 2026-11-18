<?php

namespace Database\Seeders;

use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Planning\Enums\TaskPriority;
use App\Domains\Planning\Enums\TaskStatus;
use App\Domains\Planning\Models\Task;
use App\Domains\Planning\Models\TaskCategory;
use App\Domains\Planning\Models\TimelineEvent;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use App\Domains\Wedding\Models\WeddingSetting;
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
            VendorSeeder::class,
        ]);

        // 1. Seed Super Admin
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

        // 2. Seed demo Wedding Planner
        $planner = User::firstOrCreate(
            ['email' => 'planner@wedora.lk'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Ananya Wickremasinghe (Lead Planner)',
                'password' => Hash::make('password'),
                'phone' => '+94775566778',
                'role' => UserRole::Planner,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );

        // 3. Seed demo Couple
        $couple = User::firstOrCreate(
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

        // 4. Seed demo Wedding Workspace for demo Couple
        $wedding = Wedding::firstOrCreate(
            ['owner_id' => $couple->id],
            [
                'uuid' => (string) Str::uuid(),
                'title' => 'Kasun & Dilani’s Wedding Celebration',
                'partner1_name' => 'Kasun Perera',
                'partner2_name' => 'Dilani Senaratne',
                'wedding_date' => now()->addDays(135)->toDateString(),
                'wedding_type' => WeddingType::Traditional,
                'location' => 'Cinnamon Grand Colombo (Oak Room)',
                'district' => 'Colombo',
                'estimated_guest_count' => 350,
                'total_budget' => 5800000.00,
                'currency' => 'LKR',
                'status' => WeddingStatus::Planning,
            ]
        );

        WeddingMember::firstOrCreate(
            ['wedding_id' => $wedding->id, 'user_id' => $couple->id],
            [
                'role' => WeddingMemberRole::Owner,
                'invitation_status' => InvitationStatus::Accepted,
                'permissions' => ['*'],
                'joined_at' => now(),
            ]
        );

        // Add Planner to demo Wedding workspace
        WeddingMember::firstOrCreate(
            ['wedding_id' => $wedding->id, 'user_id' => $planner->id],
            [
                'role' => WeddingMemberRole::Planner,
                'invitation_status' => InvitationStatus::Accepted,
                'permissions' => ['*'],
                'joined_at' => now(),
            ]
        );

        WeddingSetting::firstOrCreate(
            ['wedding_id' => $wedding->id],
            [
                'timezone' => 'Asia/Colombo',
                'currency' => 'LKR',
                'budget_alert_threshold_pct' => 90,
                'is_public_rsvp_enabled' => false,
                'notification_email_on_task_due' => true,
            ]
        );

        // Seed real Timeline Events for Kasun & Dilani
        $timelineEvents = [
            [
                'title' => 'Groom & Bridal Party Arrival & Dressing',
                'description' => 'Malka Atelier team begins traditional Mul Enduma & Osariya drapery.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '07:30:00',
                'end_time' => '08:30:00',
                'location' => 'Bridal Suite',
                'sort_order' => 1,
            ],
            [
                'title' => 'Magul Bera & Welcoming of Guests',
                'description' => 'Ceremonial Kandyan drummers usher bride and groom’s kin with shehnai flutes.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '08:45:00',
                'end_time' => '09:30:00',
                'location' => 'Lobby Foyer',
                'sort_order' => 2,
            ],
            [
                'title' => 'Ascent to the Poruwa Facing East (Auspicious Nekath)',
                'description' => 'Step onto the Poruwa with right foot first amidst blow of conch shell (Hakgediya) & auspicious drums.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '09:42:00',
                'end_time' => '09:55:00',
                'location' => 'Poruwa Sanctum',
                'sort_order' => 3,
            ],
            [
                'title' => 'Nuool Bandima & Gold Ring Exchange (Nekath)',
                'description' => 'Binding of couple’s little fingers with consecrated gold thread and exchange of wedding bands.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '09:55:00',
                'end_time' => '10:08:00',
                'location' => 'Poruwa Sanctum',
                'sort_order' => 4,
            ],
            [
                'title' => 'Water Pouring (Kendiya) & Jayamangala Gatha',
                'description' => 'Maternal uncle pours holy water from brass jug whilst maiden choir chants.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '10:08:00',
                'end_time' => '10:20:00',
                'location' => 'Poruwa Sanctum',
                'sort_order' => 5,
            ],
            [
                'title' => 'Descent & Breaking of the Pol (Coconut)',
                'description' => 'Stepping down together as custom clean split of fresh coconut brings warding blessing.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '10:20:00',
                'end_time' => '10:45:00',
                'location' => 'Descent Carpet',
                'sort_order' => 6,
            ],
            [
                'title' => 'Lighting of Traditional Brass Oil Lamp',
                'description' => 'Accompanied by parents and elders igniting wicks.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '10:45:00',
                'end_time' => '11:15:00',
                'location' => 'Pahana Area',
                'sort_order' => 7,
            ],
            [
                'title' => 'Grand Buffet Lunch & Celebratory Toast',
                'description' => 'Speeches by Best Man & Father of the Bride.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '12:30:00',
                'end_time' => '14:30:00',
                'location' => 'Oak Ballroom',
                'sort_order' => 8,
            ],
            [
                'title' => 'Couple Departure for Honeymoon (Departure Nekath)',
                'description' => 'Send-off towards Cape Weligama resort.',
                'event_date' => $wedding->wedding_date,
                'start_time' => '15:15:00',
                'end_time' => '15:30:00',
                'location' => 'Grand Portico',
                'sort_order' => 9,
            ],
        ];

        foreach ($timelineEvents as $evtData) {
            TimelineEvent::firstOrCreate(
                [
                    'wedding_id' => $wedding->id,
                    'title' => $evtData['title'],
                ],
                array_merge($evtData, ['uuid' => (string) Str::uuid()])
            );
        }

        // Seed real Task Categories & Tasks for Kasun & Dilani
        $ceremonyCat = TaskCategory::firstOrCreate(
            ['wedding_id' => $wedding->id, 'slug' => 'ceremony-rituals'],
            ['name' => 'Ceremony & Rituals', 'sort_order' => 1]
        );

        $cateringCat = TaskCategory::firstOrCreate(
            ['wedding_id' => $wedding->id, 'slug' => 'catering-banquet'],
            ['name' => 'Catering & Banquet', 'sort_order' => 2]
        );

        $attireCat = TaskCategory::firstOrCreate(
            ['wedding_id' => $wedding->id, 'slug' => 'attire-jewelry'],
            ['name' => 'Attire & Jewelry', 'sort_order' => 3]
        );

        $tasks = [
            [
                'category_id' => $ceremonyCat->id,
                'title' => 'Book Poruwa Master & Certified Ashtaka Chant Group',
                'description' => 'Ven. Gnanawimala lineage Ashtaka conductor for morning Poruwa rituals.',
                'due_date' => now()->addDays(15)->toDateString(),
                'priority' => TaskPriority::High,
                'status' => TaskStatus::Completed,
            ],
            [
                'category_id' => $cateringCat->id,
                'title' => 'Pay 30% Advance for Cinnamon Grand Oak Room Ballroom',
                'description' => 'Invoice #CG-8902 settlement for banquet hall reservation.',
                'due_date' => now()->addDays(20)->toDateString(),
                'priority' => TaskPriority::Urgent,
                'status' => TaskStatus::Completed,
            ],
            [
                'category_id' => $attireCat->id,
                'title' => 'Final Saree Fitting & Kandyan Jewelry Set Verification',
                'description' => 'At Malka Atelier Colombo 07. Bring the heirloom Agasti mala and padakkam for pin-placement alignment.',
                'due_date' => now()->addDays(3)->toDateString(),
                'priority' => TaskPriority::Urgent,
                'status' => TaskStatus::Pending,
            ],
            [
                'category_id' => $cateringCat->id,
                'title' => 'Finalize Sri Lankan Traditional & Continental Buffet Menu',
                'description' => 'Executive Chef tasting session: Selection of Jaffna crab curry, cashew yellow rice, and watalappam brulee.',
                'due_date' => now()->addDays(7)->toDateString(),
                'priority' => TaskPriority::Medium,
                'status' => TaskStatus::Pending,
            ],
            [
                'category_id' => $ceremonyCat->id,
                'title' => 'Schedule Magul Bera & Jayamangala Gatha Youth Choir Rehearsal',
                'description' => 'Coordinate with Choksy Troupe for entrance timings.',
                'due_date' => now()->addDays(14)->toDateString(),
                'priority' => TaskPriority::Medium,
                'status' => TaskStatus::Pending,
            ],
        ];

        foreach ($tasks as $t) {
            Task::firstOrCreate(
                [
                    'wedding_id' => $wedding->id,
                    'title' => $t['title'],
                ],
                array_merge($t, [
                    'assigned_to_user_id' => $couple->id,
                    'sort_order' => 1,
                ])
            );
        }

        // 5. Seed demo Vendor shortcut
        $vendor = User::firstOrCreate(
            ['email' => 'vendor@wedora.lk'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Dhanushka Senanayake',
                'password' => Hash::make('password'),
                'phone' => '+94772345678',
                'role' => UserRole::Vendor,
                'status' => UserStatus::Active,
                'email_verified_at' => now(),
            ]
        );
    }
}
