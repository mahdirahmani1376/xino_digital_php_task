<?php

namespace App\Actions\Item;

use App\Models\Item;

class CreateItemAction
{
    public function execute(array $data): Item
    {
        return Item::create([
            "subscription_plan_id" => $data['subscription_plan_id'],
            "amount" => $data['amount'],
            "invoice_id" => $data['invoice_id'],
        ]);
    }
}