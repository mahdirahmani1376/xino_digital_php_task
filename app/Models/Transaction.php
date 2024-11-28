<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $invoice_id
 * @property mixed $amount
 * @property mixed $status
 * @property mixed $trace_id
 */
class Transaction extends Model
{
    public $fillable = [
        'invoice_id',
        'amount',
        'status',
        'trace_id'
    ];
}
