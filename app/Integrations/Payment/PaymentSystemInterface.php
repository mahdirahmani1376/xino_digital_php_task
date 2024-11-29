<?php
namespace App\Integrations\Payment;

use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\Subscription;

interface PaymentSystemInterface {
    public function pay(Invoice $invoice);
    public function successfulCallbackPayment(array $data);
    public function cancelCallbackPayment(array $datan);
    public function autoRenewSubscription(Subscription $subscription);
    public function createPlan(Subscription $subscription);
}