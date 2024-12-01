<?php

namespace App\Actions\Invoice;

use App\Actions\Subscription\CreateSubscriptionAction;
use App\Actions\User\UpdateUserAction;
use App\Enums\InvoiceEnum;
use App\Models\Invoice;
use App\Models\Item;

class ProcessInvoiceAction
{
    public function __construct(
        private readonly UpdateInvoiceAction $updateInvoiceAction,
        private readonly UpdateUserAction $updateUserAction,
        private readonly CreateSubscriptionAction $createSubscriptionAction
    ) {}

    public function __invoke(Invoice $invoice): Invoice
    {
        ($this->updateInvoiceAction)($invoice, [
            'status' => InvoiceEnum::PAID,
        ]);

        foreach ($invoice->items as $item) {
            $this->processItem($item, $invoice);
        }

        // implement other bussiness logics

        return $invoice;
    }

    private function processItem(Item $item, Invoice $invoice)
    {
        $this->updateUserAction->execute($invoice->user, [
            'subscription_plan_id' => $item->subscription_plan_id,
        ]);

        $subscription = ($this->createSubscriptionAction)([
            'subscription_plan_id' => $item->subscription_plan_id,
            'user_id' => $invoice->user->id,
        ]);

        return $invoice;
    }
}
