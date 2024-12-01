<?php

namespace App\Http\Controllers;

use App\Actions\Invoice\CreateInvoiceAction;
use App\Actions\Invoice\PayInvoiceAction;
use App\Actions\Item\CreateItemAction;
use App\Enums\InvoiceEnum;
use App\Http\Requests\StoreInvoiceRequest;
use App\Models\Invoice;
use App\Models\SubscriptionPlan;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        return response()->json($invoice);
    }

    public function store(
        StoreInvoiceRequest $request,
        CreateInvoiceAction $createInvoiceAction,
        CreateItemAction $createItemAction
    ) {
        $data = $this->prepareDataForStore($request->validated());
        $invoice = $createInvoiceAction($data);
        $item = $createItemAction([
            'subscription_plan_id' => $data['subscription_plan_id'],
            'amount' => $invoice->amount,
            'invoice_id' => $invoice->id,
        ]);

        return response()->json(
            $invoice
        );
    }

    /**
     *  this routes gives a trace_id to fron-end of the site
     *  then the front-end will redirect the user to the payment gateway for the payment
     */
    public function pay(Invoice $invoice, PayInvoiceAction $payInvoiceAction)
    {
        return response()->json(
            [
                'redirect_url' => $payInvoiceAction($invoice),
            ]
        );
    }

    private function prepareDataForStore($data)
    {
        $data['user_id'] = request()->user()->id;
        $data['amount'] = SubscriptionPlan::firstWhere('id', $data['subscription_plan_id'])->price;
        $data['status'] = InvoiceEnum::UNPAID;

        return $data;
    }
}
