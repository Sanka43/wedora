<?php

namespace App\Domains\Wedding\Models;

use App\Domains\Identity\Models\User;
use App\Domains\Wedding\Enums\InvitationStatus;
use App\Domains\Wedding\Enums\WeddingMemberRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id',
        'user_id',
        'role',
        'invitation_status',
        'permissions',
        'joined_at',
    ];

    protected function casts(): array
    {
        return [
            'role' => WeddingMemberRole::class,
            'invitation_status' => InvitationStatus::class,
            'permissions' => 'array',
            'joined_at' => 'datetime',
        ];
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
