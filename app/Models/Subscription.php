<?php

namespace App\Models;

use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property $subscription_plan_id
 * @property $user_id
 * @property $expired_at
 */
class Subscription extends Model
{
    use HasFactory;

    public $fillable = [
        "subscription_plan_id",
        "user_id",
        "expired_at",
    ];
    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class,'subscription_plan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
