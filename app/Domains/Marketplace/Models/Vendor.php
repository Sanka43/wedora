<?php

namespace App\Domains\Marketplace\Models;

use App\Domains\Booking\Models\Booking;
use App\Domains\Booking\Models\Quotation;
use App\Domains\Booking\Models\Review;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Enums\VerificationStatus;
use App\Domains\Platform\Models\Subscription;
use App\Domains\Platform\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, HasUuid, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'category_id',
        'business_name',
        'slug',
        'description',
        'district',
        'address',
        'phone',
        'email',
        'website',
        'instagram_handle',
        'facebook_url',
        'starting_price',
        'currency',
        'verification_status',
        'is_active',
        'is_featured',
        'rating_avg',
        'reviews_count',
    ];

    protected function casts(): array
    {
        return [
            'starting_price' => 'decimal:2',
            'verification_status' => VerificationStatus::class,
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'rating_avg' => 'decimal:2',
            'reviews_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(VendorCategory::class, 'category_id');
    }

    public function packages(): HasMany
    {
        return $this->hasMany(VendorPackage::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(VendorMedia::class);
    }

    public function coverMedia()
    {
        return $this->hasOne(VendorMedia::class)->where('is_cover', true);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
