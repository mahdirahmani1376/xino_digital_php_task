<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
* @property $invoice_id
* @property $subscription_plan_id
* @property $amount
 */
class Item extends Model
{
    protected $fillable = [
        "invoice_id",
        "subscription_plan_id",
        "amount",
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
}
