<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->plans() as $plan) {
            SubscriptionPlan::create([
                'name' => $plan['name'],
                'priority' => $plan['priority'],
                'price' => $plan['price'],
            ]);
        }
    }

    private function plans()
    {
        return [
            [
                'name' => 'bronze',
                'priority' => 1,
                'price' => 5,
            ],
            [
                'name' => 'silver',
                'priority' => 2,
                'price' => 10,

            ],
            [
                'name' => 'gold',
                'priority' => 3,
                'price' => 20,
            ],
        ];
    }
}
