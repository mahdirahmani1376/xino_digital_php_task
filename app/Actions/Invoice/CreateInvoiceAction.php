<?php

namespace App\Actions\Invoice;

use App\Models\Invoice;

class CreateInvoiceAction
{
    public function exectue($data)
    {
        return Invoice::create([
            'amount' => $data['amount'],
            'user_id' => $data['user_id'],
            'status' => $data['status'],
        ]);
    }
}
