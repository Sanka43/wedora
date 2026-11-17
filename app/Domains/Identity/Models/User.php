<?php

namespace App\Domains\Identity\Models;

use App\Domains\Booking\Models\Review;
use App\Domains\Identity\Enums\UserRole;
use App\Domains\Identity\Enums\UserStatus;
use App\Domains\Marketplace\Models\Favorite;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Platform\Models\Subscription;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Models\WeddingMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasUuid, Notifiable, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'status' => UserStatus::class,
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function ownedWeddings(): HasMany
    {
        return $this->hasMany(Wedding::class, 'owner_id');
    }

    public function weddingMemberships(): HasMany
    {
        return $this->hasMany(WeddingMember::class);
    }

    public function weddings(): BelongsToMany
    {
        return $this->belongsToMany(Wedding::class, 'wedding_members')
            ->withPivot(['role', 'invitation_status', 'permissions', 'joined_at'])
            ->withTimestamps();
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoriteVendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class, 'favorites');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === UserRole::SuperAdmin;
    }

    public function isCouple(): bool
    {
        return $this->role === UserRole::Couple;
    }

    public function isVendor(): bool
    {
        return $this->role === UserRole::Vendor;
    }

    public function isPlanner(): bool
    {
        return $this->role === UserRole::Planner;
    }
}
