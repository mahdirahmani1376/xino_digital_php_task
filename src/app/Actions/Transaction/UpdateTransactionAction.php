<?php

namespace App\Actions\Transaction;

use App\Models\Transaction;

class UpdateTransactionAction
{
    public function __invoke(Transaction $transaction, array $data): Transaction
    {
        $transaction->update($data);

        return $transaction;
    }
}
