<?php

namespace App\Actions\Invoice;

use App\Models\Invoice;

class CreateInvoiceAction
{
    public function makeInvoice($data)
    {
        return Invoice::create([
            'amount' => $data['amount'],
            'user' => $data['user'],
            'status' => $data['status'],
        ]);
    }
}
