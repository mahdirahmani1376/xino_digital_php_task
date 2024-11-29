<?php

namespace App\Actions\Subscription;

use App\Models\Subscription;

class CreateSubscriptionAction
{
    public function __invoke(array $data)
    {
        return Subscription::create([
            "subscription_plan_id" => $data['subscription_plan_id'],
            "user_id" => $data['user_id'],
            "expired_at" => $data['expired_at'],
        ]);
    }
}