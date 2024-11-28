<?php
namespace App\Actions\Invoice;

use App\Models\Item;
use App\Models\Invoice;
use App\Enums\InvoiceEnum;
use App\Actions\Invoice\UpdateInvoiceAction;
use App\Models\SubscriptionPlan;
use App\Actions\User\UpdateUserAction;

class ProcessInvoiceAction {

    public function __construct(
        private readonly UpdateInvoiceAction $updateInvoiceAction,
        private readonly UpdateUserAction $updateUserAction
    ){

    }
    public function execute(Invoice $invoice): Invoice
    {
        $this->updateInvoiceAction->execute($invoice,[
            'status' => InvoiceEnum::PAID
        ]);

        foreach($invoice->items as $item){
            $this->processItem($item,$invoice);
        }

        // implement other bussiness logics

        return $invoice;
    }

    private function processItem(Item $item,Invoice $invoice)
    {
        if ($item->invoiceable_type === SubscriptionPlan::class) {
            $this->updateUserAction->execute($invoice->user,[
                'subscription_plan_id' => $item->invoiceable_id
            ]);
        }
    }
}