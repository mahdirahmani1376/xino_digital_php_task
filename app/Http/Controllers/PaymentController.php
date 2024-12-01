<?php

namespace App\Http\Controllers;

use App\Integrations\Payment\PaymentSystemInterface;
use App\Models\Subscription;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function success(
        Request $request,
        PaymentSystemInterface $paymentSystem,
    ) {
        $data = $request->validate(
            [
                'paymentId' => ['required', 'exists:transactions,trace_id'],
            ]);

        $paymentSystem->successfulCallbackPayment($data);

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function cancel(
        Request $request,
        PaymentSystemInterface $paymentSystem,
    ) {
        $data = $request->validate(
            [
                'paymentId' => ['required', 'exists:transactions,trace_id'],
            ]);

        $paymentSystem->cancelCallbackPayment($data);

        return response()->json([
            'message' => 'transaction cancelled',
        ]);
    }

    public function webhook(Request $request, PaymentSystemInterface $paymentSystem)
    {
        $event = $request->validate([
            'id' => ['required'],
            'paymentId' => ['required'],
        ]);

        $subscription = Subscription::where([
            'id' => $event['id'],
        ])->firstOrFail();

        $subscription = $paymentSystem->autoRenewSubscription($subscription, $event);

        return response()->json($subscription);
    }

    public function createPlan(Request $request, PaymentSystemInterface $paymentSystem)
    {
        $subscription = Subscription::where([
            'id' => $request->subscription_id,
        ])->firstOrFail();

        $paymentSystem->createPlan($subscription);

        return response()->json([
            'message' => 'success',
        ]);
    }
}
