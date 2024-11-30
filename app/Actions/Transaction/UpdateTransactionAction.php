<?php

namespace App\Actions\Transaction;

use App\Models\Invoice;
use App\Models\Transaction;
use App\Enums\TransactionEnum;

class UpdateTransactionAction {
    public function __invoke(Transaction $transaction,array $data): Transaction {
        $transaction->update($data);
        return $transaction;
    }
}