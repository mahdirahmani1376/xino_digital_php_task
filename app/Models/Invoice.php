<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed $amount
 * @property mixed $amount
 * @property mixed $user_id
 */
class Invoice extends Model
{
    public $fillable = [
        'amount',
        'user_id',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class,'invoice_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
