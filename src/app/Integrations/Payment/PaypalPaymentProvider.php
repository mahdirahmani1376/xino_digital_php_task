<?php

namespace App\Integrations\Payment;

use App\Actions\Invoice\CreateInvoiceAction;
use App\Actions\Invoice\ProcessInvoiceAction;
use App\Actions\Item\CreateItemAction;
use App\Actions\Subscription\UpdateSubscriptionAction;
use App\Actions\Transaction\StoreTransactionAction;
use App\Actions\Transaction\UpdateTransactionAction;
use App\Enums\InvoiceEnum;
use App\Enums\TransactionEnum;
use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;

class PaypalPaymentProvider implements PaymentSystemInterface
{
    private $baseUrl;

    private $clientId;

    private $clientSecret;

    private $token;

    public function __construct(
        private readonly StoreTransactionAction $storeTransactionAction,
        private readonly UpdateTransactionAction $updateTransactionAction,
        private readonly ProcessInvoiceAction $processInvoiceAction,
    ) {
        $this->init();
    }

    private function init()
    {
        $this->baseUrl = config('payment.paypal.base_url');
        $this->clientId = config('payment.paypal.client_id');
        $this->clientSecret = config('payment.paypal.client_secret');
    }

    private function getAccessToken()
    {
        // $response = Http::asForm()->withBasicAuth($this->clientId, $this->clientSecret)
        //     ->post("{$this->baseUrl}/v1/oauth2/token", [
        //         'grant_type' => 'client_credentials',
        //     ]);

        // return $response->json()['access_token'];

        return 'test';
    }

    public function createPlan(Subscription $subscription)
    {

        $accessToken = $this->getAccessToken();

        // $response = Http::withToken($accessToken)->post("{$this->baseUrl}/v1/billing/plans", [
        //     'product_id' => $subscription->id,
        //     'name' => $subscription->name,
        //     'description' => 'Monthly subscription plan',
        //     'billing_cycles' => [
        //         [
        //             'frequency' => ['interval_unit' => 'MONTH', 'interval_count' => 1],
        //             'tenure_type' => 'REGULAR',
        //             'sequence' => 1,
        //             'total_cycles' => 0,
        //             'pricing_scheme' => ['fixed_price' => ['value' => $subscription->subscriptionPlan->price, 'currency_code' => 'USD']],
        //         ],
        //     ],
        //     'payment_preferences' => [
        //         'auto_bill_outstanding' => true,
        //         'setup_fee' => ['value' => '0.00', 'currency_code' => 'USD'],
        //         'setup_fee_failure_action' => 'CANCEL',
        //         'payment_failure_threshold' => 3,
        //     ],
        // ]);

        // return $response->json();

        return [
            'state' => 'approved',
        ];

    }

    public function pay(Invoice $invoice)
    {
        $transaction = ($this->storeTransactionAction)([
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount,
            'trace_id' => null,
            'status' => TransactionEnum::PENDING,
        ]);

        $traceId = $this->createPayment($transaction);

        return $this->baseUrl.'/payment.'.$traceId;
    }

    public function successfulCallbackPayment(array $data)
    {
        $transaction = Transaction::where('trace_id', $data['paymentId'])->first();

        ($this->updateTransactionAction)($transaction, [
            'status' => TransactionEnum::SUCCESS,
        ]);

        $invoice = ($this->processInvoiceAction)($transaction->invoice);

    }

    public function cancelCallbackPayment(array $data)
    {
        $transaction = Transaction::where('trace_id', $data['paymentId'])->first();
        $this->failTransaction($transaction);
    }

    private function createPayment(Transaction $transaction)
    {
        $paymentData = [
            'intent' => 'sale',
            'redirect_urls' => [
                'return_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ],
            'payer' => [
                'payment_method' => 'paypal',
            ],
            'transactions' => [
                [
                    'amount' => [
                        'total' => $transaction->amount,
                        'currency' => 'USD',
                    ],
                    'description' => 'Test payment',
                ],
            ],
        ];

        // $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
        //     ->post("{$this->baseUrl}/v1/payments/payment", $paymentData)->json();

        // $traceId = $response->json('paymentId');
        $traceId = 'test';
        if ($traceId) {
            ($this->updateTransactionAction)($transaction, [
                'trace_id' => $traceId,
            ]);

            return $traceId;
        } else {
            return $this->failTransaction($transaction);
        }

    }

    private function failTransaction(Transaction $transaction)
    {
        ($this->updateTransactionAction)($transaction, [
            'status' => TransactionEnum::FAILED,
        ]);

    }

    public function autoRenewSubscription(Subscription $subscription, array $event)
    {
        $subscriptionPlan = $subscription->subscriptionPlan;

        $invoice = app(CreateInvoiceAction::class)([
            'amount' => $subscriptionPlan->price,
            'user_id' => $subscription->user->id,
            'status' => InvoiceEnum::PAID,
        ]);

        $transaction = app(StoreTransactionAction::class)([
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount,
            'status' => TransactionEnum::SUCCESS,
            'trace_id' => $event['paymentId'],
        ]);

        $item = app(CreateItemAction::class)([
            'subscription_plan_id' => $subscriptionPlan->id,
            'amount' => $subscriptionPlan->price,
            'invoice_id' => $invoice->id,
        ]);

        app(UpdateSubscriptionAction::class)($subscription, [
            'expired_at' => now()->addMonth(),
        ]);

        return $subscription;

    }
}
