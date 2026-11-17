<?php

namespace App\Domains\Wedding\Models;

use App\Domains\Booking\Models\Booking;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Booking\Models\Review;
use App\Domains\Budget\Models\Budget;
use App\Domains\Budget\Models\Expense;
use App\Domains\Budget\Models\Payment;
use App\Domains\Communication\Models\Conversation;
use App\Domains\Guest\Models\Guest;
use App\Domains\Guest\Models\GuestGroup;
use App\Domains\Identity\Models\User;
use App\Domains\Planning\Models\Task;
use App\Domains\Planning\Models\TaskCategory;
use App\Domains\Planning\Models\TimelineEvent;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Enums\WeddingStatus;
use App\Domains\Wedding\Enums\WeddingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wedding extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'owner_id',
        'title',
        'partner1_name',
        'partner2_name',
        'wedding_date',
        'wedding_type',
        'location',
        'district',
        'estimated_guest_count',
        'total_budget',
        'currency',
        'style_theme',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'wedding_date' => 'date',
            'wedding_type' => WeddingType::class,
            'status' => WeddingStatus::class,
            'estimated_guest_count' => 'integer',
            'total_budget' => 'decimal:2',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(WeddingMember::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wedding_members')
            ->withPivot(['role', 'invitation_status', 'permissions', 'joined_at'])
            ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(WeddingInvitation::class);
    }

    public function setting(): HasOne
    {
        return $this->hasOne(WeddingSetting::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function taskCategories(): HasMany
    {
        return $this->hasMany(TaskCategory::class);
    }

    public function timelineEvents(): HasMany
    {
        return $this->hasMany(TimelineEvent::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function guestGroups(): HasMany
    {
        return $this->hasMany(GuestGroup::class);
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
