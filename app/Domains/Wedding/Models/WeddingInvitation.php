<?php

namespace App\Domains\Wedding\Models;

use App\Domains\Identity\Models\User;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingInvitation extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'invited_by_user_id',
        'email',
        'role',
        'token',
        'status',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'role' => WeddingMemberRole::class,
            'status' => InvitationStatus::class,
            'expires_at' => 'datetime',
        ];
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function invitedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by_user_id');
    }
}
