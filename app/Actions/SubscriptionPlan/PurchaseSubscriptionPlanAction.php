<?php
namespace App\Actions\SubscriptionPlan;

use App\Models\SubscriptionPlan;
use App\Actions\Invoice\PayInvoiceAction;

class PurchaseSubscriptionPlanAction 
{
    public function __construct(
        public readonly PayInvoiceAction $payInvoiceAction
    )
    {

    }

    public function purchase(SubscriptionPlan $subscriptionPlan)
    {
        
    }
}