<?php

namespace App\Actions\Item;

use App\Models\Item;

class CreateItemAction
{
    public function execute(array $data): Item
    {
        return Item::create([
            ''
        ]);
    }
}