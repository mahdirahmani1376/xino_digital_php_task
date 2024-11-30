<?php

namespace App\Actions\Invoice;

use App\Models\Invoice;

class UpdateInvoiceAction
{
    public function __invoke(Invoice $invoice, array $data)
    {
        $invoice->update($data);

        return $invoice;
    }
}