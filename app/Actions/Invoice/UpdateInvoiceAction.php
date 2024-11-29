<?php

namespace App\Actions\Invoice;

use App\Models\Invoice;

class UpdateInvoiceAction
{
    public function execute(Invoice $invoice, array $data)
    {
        $invoice->update($data);

        return $invoice;
    }
}