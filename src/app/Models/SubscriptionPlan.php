<?php

namespace App\Models;

use App\Enums\BillingCycleEnum;
use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class SubscriptionPlan extends Model
{
    use TorkActivityLogTrait;
    protected $table = 'subscription_plans';
    protected $guarded = [];

    protected $casts = [
        'billing_cycle' => BillingCycleEnum::class,
    ];

    //RELATIONAL METHOD
}
