<?php

namespace App\Domains\Platform\Models;

use App\Domains\Platform\Enums\BillingInterval;
use App\Domains\Platform\Enums\SubscriptionTargetType;
use App\Domains\Platform\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubscriptionPlan extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'target_type',
        'billing_interval',
        'price',
        'currency',
        'features',
        'max_packages',
        'max_portfolio_images',
        'is_featured_badge',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'target_type' => SubscriptionTargetType::class,
            'billing_interval' => BillingInterval::class,
            'price' => 'decimal:2',
            'features' => 'array',
            'max_packages' => 'integer',
            'max_portfolio_images' => 'integer',
            'is_featured_badge' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
