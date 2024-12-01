<?php

namespace App\Actions\Transaction;

use App\Models\Transaction;

class StoreTransactionAction
{
    public function __invoke(array $data): Transaction
    {
        return Transaction::query()->create([
            'invoice_id' => $data['invoice_id'],
            'amount' => $data['amount'],
            'status' => $data['status'],
            'trace_id' => $data['trace_id'],
        ]);
    }
}
