<?php

namespace App\Actions\Invoice;

use App\Actions\Transaction\StoreTransactionAction;
use App\Enums\TransactionEnum;
use App\Integrations\Payment\PaymentSystemInterface;
use App\Models\Invoice;

class PayInvoiceAction
{
    public function __construct(
        public readonly PaymentSystemInterface $paymentSystem,
        public readonly StoreTransactionAction $storeTransactionAction
    ) {}

    public function __invoke(Invoice $invoice)
    {
        $transaction = ($this->storeTransactionAction)([
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount,
            'status' => TransactionEnum::PENDING,
            'trace_id' => null,
        ]);

        return $this->paymentSystem->pay($invoice);

    }
}
