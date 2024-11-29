<?php

namespace App\Actions\Transaction;

use App\Models\Invoice;
use App\Models\Transaction;
use App\Enums\TransactionEnum;

class StoreTransactionAction {
    public function execute(array $data): Transaction {
        return Transaction::query()->create([
            'invoice_id' => $data['invoice_id'],
            'amount' => $data['amount'],
            'status' => $data['status'],
            'trace_id' => $data['trace_id']
        ]);
    }
}