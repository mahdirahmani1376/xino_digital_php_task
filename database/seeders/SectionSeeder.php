<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->sections() as $section) {
            Section::create([
                'name' => $section['name'],
                'subscription_plan_id' => $section['subscription_plan_id'],
            ]);
        }
    }

    private function sections()
    {
        $subscriptionplans = SubscriptionPlan::all();
        $bronze = $subscriptionplans->firstWhere('name', 'bronze')->id;
        $silver = $subscriptionplans->firstWhere('name', 'silver')->id;
        $gold = $subscriptionplans->firstWhere('name', 'gold')->id;

        $sections = [
            [
                'name' => 'view_course',
                'subscription_plan_id' => $bronze,
            ],
            [
                'name' => 'download_course',
                'subscription_plan_id' => $silver,
            ],
            [
                'name' => 'send_direct_messages_to_mentor',
                'subscription_plan_id' => $gold,
            ],
        ];

        return $sections;
    }
}
