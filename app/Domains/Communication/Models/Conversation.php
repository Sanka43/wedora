<?php

namespace App\Domains\Communication\Models;

use App\Domains\Booking\Models\Booking;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Communication\Enums\ConversationType;
use App\Domains\Identity\Models\User;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Models\Wedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'quotation_id',
        'booking_id',
        'type',
        'title',
    ];

    protected function casts(): array
    {
        return [
            'type' => ConversationType::class,
        ];
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(ConversationMember::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_members')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }
}
