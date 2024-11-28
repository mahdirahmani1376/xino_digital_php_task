<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'priority' => $plan['priority']
            ]);
        }
    }

    private function plans()
    {
        return [
            [
                'name' => 'bronze',
                'priority' => 1
            ],
            [
                'name' => 'silver',
                'priority' => 2
            ],
            [
                'name' => 'gold',
                'priority' => 3
            ]
            ];
    }
}
