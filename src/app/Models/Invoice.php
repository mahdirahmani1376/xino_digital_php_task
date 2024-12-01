<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed $amount
 * @property mixed $user_id
 * @property mixed $status
 */
class Invoice extends Model
{
    use HasFactory;

    public $fillable = [
        'amount',
        'user_id',
        'status',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'invoice_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
