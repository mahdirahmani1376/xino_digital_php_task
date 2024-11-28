<?php

namespace App\Models;

/**
 * @property $name
 * @property $subscripition_plan_id
 */
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    public function subscriptionPlan(): BelongsTo  
    {
        return $this->belongsTo(SubscriptionPlan::class,'subscription_plan_id');
    }
}
