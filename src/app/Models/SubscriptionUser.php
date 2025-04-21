<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//Activity Log
use App\Traits\TorkActivityLogTrait;

class SubscriptionUser extends Model
{
    use TorkActivityLogTrait;
    protected $table = 'subscription_users';
    protected $guarded = [];


    public function scopeWithUser($query)
    {
        return $query->leftJoin('users', 'subscription_users.user_id', '=', 'users.id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeWithSubscriptionPlan($query)
    {
        return $query->leftJoin('subscription_plans', 'subscription_users.plan_id', '=', 'subscription_plans.id');
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'plan_id', 'id');
    }
    //RELATIONAL METHOD




}
