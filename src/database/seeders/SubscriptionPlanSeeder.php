<?php

namespace Database\Seeders;

use App\Enums\TodoStatus;
use Illuminate\Support\Str;
use App\Models\backend\Todo;
use App\Enums\BillingCycleEnum;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $plans = [
            [
                'title'         => 'Basic',
                'banner'        => 'assets/images/plans/basic_plan.png',
                'billing_cycle' => BillingCycleEnum::WEEKLY,
                'price'         => 499,
                'is_popular'    => 0,
                'level'         => 1,
                'status'        => 1,
                'description'   => 'This is basic plan for starter, Duration is weekly',
            ],
            [
                'title'         => 'Standard',
                'banner'        => 'assets/images/plans/standard_plan.png',
                'billing_cycle' => BillingCycleEnum::MONTHLY,
                'price'         => 999,
                'is_popular'    => 1,
                'level'         => 2,
                'status'        => 1,
                'description'   => 'This is standard plan and popular, Duration is monthly',
            ],
            [
                'title'         => 'Premium',
                'banner'        => 'assets/images/plans/premium_plan.png',
                'billing_cycle' => BillingCycleEnum::YEARLY,
                'price'         => 9999,
                'is_popular'    => 0,
                'level'         => 3,
                'status'        => 1,
                'description'   => 'This is premium plan for elite, Duration is yearly',
            ],
        ];

        foreach ($plans as $key => $plan) {
            SubscriptionPlan::create([
                'title'         => $plan['title'],
                'slug'          => Str::slug($plan['title']),
                'banner'        => $plan['banner'],
                'billing_cycle' => $plan['billing_cycle']->value,
                'price'         => $plan['price'],
                'is_popular'    => $plan['is_popular'],
                'level'         => $plan['level'],
                'order'         => ++$key,
                'is_active'     => $plan['status'],
                'description'   => $plan['description'],
            ]);
        }
    }
}
