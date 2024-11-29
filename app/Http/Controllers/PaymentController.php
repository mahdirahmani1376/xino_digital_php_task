<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Integrations\Payment\PaymentSystemInterface;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function success(
        Request $request,
        PaymentSystemInterface $paymentSystem,
        )
    {
        $data = $request->validate(
            [
                'paymentId' => ['required','exists:transactions,trace_id'],
            ]);

        $invoice = $paymentSystem->successfulCallbackPayment($data);

        return response()->json($invoice);
    }

    public function cancel(
        Request $request,
        PaymentSystemInterface $paymentSystem,
        )
    {
        $data = $request->validate(
            [
                'paymentId' => ['required','exists:transactions,trace_id'],
            ]);

        $invoice = $paymentSystem->cancelCallbackPayment($data);

        return response()->json($invoice);
    }

    public function webhook(Request $request,PaymentSystemInterface $paymentSystem)
    {
        $event = $request->all();

        $subscription = Subscription::where([
            'id' => $event['id']
        ])->firstOrFail();

        $subscription = $paymentSystem->autoRenewSubscription($subscription);

        return response()->json($subscription);
    }

    public function createPlan(Subscription $subscription,PaymentSystemInterface $paymentSystem)
    {
        $paymentSystem->createPlan($subscription);

        return response()->json([
            'message' => 'success'
        ]);
    }

}
