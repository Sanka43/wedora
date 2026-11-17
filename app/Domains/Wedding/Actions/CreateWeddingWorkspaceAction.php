<?php

namespace App\Domains\Wedding\Actions;

use App\Domains\Identity\Models\User;
use App\Domains\Planning\Enums\TaskPriority;
use App\Domains\Planning\Enums\TaskStatus;
use App\Domains\Planning\Models\ChecklistTemplate;
use App\Domains\Planning\Models\Task;
use App\Domains\Planning\Models\TaskCategory;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use App\Domains\Wedding\Models\WeddingSetting;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateWeddingWorkspaceAction
{
    /**
     * Create a new wedding workspace for a couple.
     *
     * @param User $owner
     * @param array<string, mixed> $data
     * @return Wedding
     */
    public function execute(User $owner, array $data): Wedding
    {
        return DB::transaction(function () use ($owner, $data) {
            $weddingType = isset($data['wedding_type'])
                ? ($data['wedding_type'] instanceof WeddingType ? $data['wedding_type'] : WeddingType::from($data['wedding_type']))
                : WeddingType::Traditional;

            $title = $data['title'] ?? sprintf("%s & %s's Wedding", $data['partner1_name'], $data['partner2_name']);

            $wedding = Wedding::create([
                'owner_id' => $owner->id,
                'title' => $title,
                'partner1_name' => $data['partner1_name'],
                'partner2_name' => $data['partner2_name'],
                'wedding_date' => $data['wedding_date'],
                'wedding_type' => $weddingType,
                'location' => $data['location'] ?? null,
                'district' => $data['district'] ?? 'Colombo',
                'estimated_guest_count' => (int) ($data['estimated_guest_count'] ?? 100),
                'total_budget' => (float) ($data['total_budget'] ?? 0.00),
                'currency' => $data['currency'] ?? 'LKR',
                'style_theme' => $data['style_theme'] ?? null,
                'status' => WeddingStatus::Planning,
            ]);

            // Add owner as accepted workspace member
            WeddingMember::create([
                'wedding_id' => $wedding->id,
                'user_id' => $owner->id,
                'role' => WeddingMemberRole::Owner,
                'invitation_status' => InvitationStatus::Accepted,
                'permissions' => ['all' => true],
                'joined_at' => now(),
            ]);

            // Initialize default settings
            WeddingSetting::create([
                'wedding_id' => $wedding->id,
                'timezone' => 'Asia/Colombo',
                'currency' => 'LKR',
                'budget_alert_threshold_pct' => 90,
                'is_public_rsvp_enabled' => false,
                'notification_email_on_task_due' => true,
            ]);

            // Set current wedding context temporarily to seed tasks
            $manager = app(CurrentWeddingManager::class);
            $manager->set($wedding);

            // Clone starter checklist template tasks if available
            $this->seedChecklistTasks($wedding);

            // Save active wedding into session
            if (session()) {
                session(['active_wedding_uuid' => $wedding->uuid]);
            }

            return $wedding;
        });
    }

    protected function seedChecklistTasks(Wedding $wedding): void
    {
        $template = ChecklistTemplate::with('items')
            ->where('is_active', true)
            ->where(function ($query) use ($wedding) {
                $query->where('wedding_type', $wedding->wedding_type->value)
                    ->orWhere('wedding_type', 'traditional');
            })
            ->first();

        if (!$template || $template->items->isEmpty()) {
            return;
        }

        $weddingDate = Carbon::parse($wedding->wedding_date);
        $categoriesMap = [];

        foreach ($template->items as $item) {
            $catName = $item->category_name ?? 'General Planning';
            if (!isset($categoriesMap[$catName])) {
                $category = TaskCategory::firstOrCreate(
                    [
                        'wedding_id' => $wedding->id,
                        'name' => $catName,
                    ],
                    [
                        'slug' => Str::slug($catName),
                        'sort_order' => count($categoriesMap) + 1,
                        'is_default' => false,
                    ]
                );
                $categoriesMap[$catName] = $category->id;
            }

            $dueDate = $weddingDate->copy()->addDays($item->suggested_due_offset_days ?? 0);

            Task::create([
                'wedding_id' => $wedding->id,
                'category_id' => $categoriesMap[$catName],
                'title' => $item->title,
                'description' => $item->description,
                'due_date' => $dueDate->toDateString(),
                'priority' => $item->priority ?? TaskPriority::Medium,
                'status' => TaskStatus::Pending,
                'sort_order' => $item->sort_order,
            ]);
        }
    }
}
