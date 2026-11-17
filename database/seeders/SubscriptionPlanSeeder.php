<?php

namespace Database\Seeders;

use App\Domains\Platform\Enums\BillingInterval;
use App\Domains\Platform\Enums\SubscriptionTargetType;
use App\Domains\Platform\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Vendor Starter (Free)',
                'slug' => 'vendor-free',
                'target_type' => SubscriptionTargetType::Vendor,
                'billing_interval' => BillingInterval::Monthly,
                'price' => 0.00,
                'currency' => 'LKR',
                'features' => [
                    'Standard directory profile',
                    'Up to 1 package',
                    'Up to 5 portfolio photos',
                    'Direct couple inquiry notifications',
                ],
                'max_packages' => 1,
                'max_portfolio_images' => 5,
                'is_featured_badge' => false,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Vendor Pro',
                'slug' => 'vendor-pro',
                'target_type' => SubscriptionTargetType::Vendor,
                'billing_interval' => BillingInterval::Monthly,
                'price' => 4500.00,
                'currency' => 'LKR',
                'features' => [
                    'Enhanced profile with direct social links',
                    'Up to 5 customizable packages',
                    'Up to 25 portfolio photos & video embeds',
                    'In-app messaging & quotation management',
                    'Analytics & profile view reports',
                ],
                'max_packages' => 5,
                'max_portfolio_images' => 25,
                'is_featured_badge' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Vendor Premium (Featured)',
                'slug' => 'vendor-premium',
                'target_type' => SubscriptionTargetType::Vendor,
                'billing_interval' => BillingInterval::Monthly,
                'price' => 9500.00,
                'currency' => 'LKR',
                'features' => [
                    'Verified & Featured badge on directory',
                    'Top placement in category searches',
                    'Unlimited packages',
                    'Up to 100 high-res photos & showcase reels',
                    'Priority instant RFQ dispatch',
                    'Dedicated vendor success support',
                ],
                'max_packages' => 50,
                'max_portfolio_images' => 100,
                'is_featured_badge' => true,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Certified Wedding Planner Pro',
                'slug' => 'planner-pro',
                'target_type' => SubscriptionTargetType::Planner,
                'billing_interval' => BillingInterval::Monthly,
                'price' => 15000.00,
                'currency' => 'LKR',
                'features' => [
                    'Multi-wedding workspace dashboard',
                    'Unlimited couple client management',
                    'Direct RFQ dispatch to any marketplace vendor',
                    'Custom budget & timeline templates',
                    'White-labeled couple exported summaries',
                ],
                'max_packages' => 10,
                'max_portfolio_images' => 50,
                'is_featured_badge' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::firstOrCreate(
                ['slug' => $plan['slug']],
                array_merge($plan, [
                    'uuid' => (string) Str::uuid(),
                ])
            );
        }
    }
}
