<?php

namespace App\Actions\Subscription;

use App\Models\Subscription;

class UpdateSubscriptionAction
{
    public function __invoke(Subscription $subscription, array $data)
    {
        $subscription->update($data);

        return $subscription;
    }
}
