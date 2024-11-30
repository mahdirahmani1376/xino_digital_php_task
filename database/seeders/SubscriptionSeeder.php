<?php

namespace Database\Seeders;

use App\Actions\Subscription\CreateSubscriptionAction;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $subscriptionPlans = SubscriptionPlan::all();

        foreach ($users as $user) {
            $subscription = app(CreateSubscriptionAction::class)([
                "subscription_plan_id" => $subscriptionPlans->random()->id,
                "user_id" => $user->id,
            ]);
            $user->update([
                'subscription_id' => $subscription->id
            ]);
        }
    }
}
