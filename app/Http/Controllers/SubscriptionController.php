<?php

namespace App\Http\Controllers;

use App\Actions\Invoice\CreateInvoiceAction;
use App\Actions\Subscription\CreateSubscriptionAction;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function store(
        Request $request,
        CreateSubscriptionAction $createSubscriptionAction,
        CreateInvoiceAction $createInvoiceAction
    ) {
        $data = $request->validate([
            'subscription_plan_id' => ['required', 'exists:subscription_plans,id'],
        ]);

        $data['user_id'] = $request()->user()->id;

        $subscription = $createSubscriptionAction($data);

        return response()->json(
            $createSubscriptionAction($data)
        );
    }
}
