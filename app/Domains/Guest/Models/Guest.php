<?php

namespace App\Domains\Guest\Models;

use App\Domains\Guest\Enums\GuestInvitationStatus;
use App\Domains\Guest\Enums\RsvpStatus;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory, HasUuid, BelongsToWedding, SoftDeletes;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'guest_group_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'invitation_status',
        'rsvp_status',
        'invited_count',
        'attending_count',
        'dietary_requirements',
        'table_assignment',
        'notes',
        'rsvp_token',
        'rsvp_responded_at',
    ];

    protected function casts(): array
    {
        return [
            'invitation_status' => GuestInvitationStatus::class,
            'rsvp_status' => RsvpStatus::class,
            'invited_count' => 'integer',
            'attending_count' => 'integer',
            'rsvp_responded_at' => 'datetime',
        ];
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(GuestGroup::class, 'guest_group_id');
    }
}
