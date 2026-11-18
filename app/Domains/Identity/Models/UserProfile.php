<?php

namespace App\Domains\Identity\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'partner_name',
        'company_name',
        'designation',
        'bio',
        'experience_years',
        'specializations',
        'operating_districts',
        'website',
        'instagram_handle',
        'facebook_url',
        'address',
        'avatar_url',
        'preferred_locale',
        'notification_preferences',
    ];

    protected function casts(): array
    {
        return [
            'experience_years' => 'integer',
            'specializations' => 'array',
            'operating_districts' => 'array',
            'notification_preferences' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
