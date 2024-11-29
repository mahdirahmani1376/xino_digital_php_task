<?php
namespace App\Actions\Invoice;

use App\Models\Invoice;
use App\Integrations\Payment\PaymentSystemInterface;
use App\Actions\Transaction\StoreTransactionAction;
use App\Enums\TransactionEnum;

class PayInvoiceAction {
    public function __construct(
        public readonly PaymentSystemInterface $paymentSystem,
        public readonly StoreTransactionAction $storeTransactionAction
    ){}


    public function pay(Invoice $invoice)
    {
        $transaction = $this->storeTransactionAction->execute([
            "invoice_id" => $invoice->id,
            "amount" => $invoice->amount,
            "status" => TransactionEnum::PENDING,
        ]);

        $status = $this->paymentSystem->pay($invoice);

    }
}