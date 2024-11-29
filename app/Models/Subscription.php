<?php

namespace App\Models;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property $subscription_plan_id
 * @property $user_id
 * @property $expired_at
 */
class Subscription extends Model
{
    public $fillable = [
        "subscription_plan_id",
        "user_id",
        "expired_at",
    ];
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }
}
