<?php

namespace App\Actions\Invoice;

use App\Models\Invoice;

class CreateInvoiceAction
{
    public function exectue($data)
    {
        return Invoice::create([
            'amount' => $data['amount'],
            'user' => $data['user'],
            'status' => $data['status'],
        ]);
    }
}
