<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->sections() as $section)
        {
            Section::create([
                'name' => $section['name'],
                'subscription_plan_id' => $section['subscription_plan_id']
            ]);
        }
    }

    private function sections()
    {
        $subscriptionplans = SubscriptionPlan::all();
        $bronze = $subscriptionplans->firstWhere('name','bronze')->id;
        $silver = $subscriptionplans->firstWhere('name','silver')->id;
        $gold = $subscriptionplans->firstWhere('name','gold')->id;
        
        $sections = [
            [
                'name' => 'Access to All Courses	',
                'subscription_plan_id' => $bronze
            ],
            [
                'name' => 'Downloadable Materials	',
                'subscription_plan_id' => $silver
            ],
            [
                'name' => 'Mentorship',
                'subscription_plan_id' => $gold
            ],
            [
                'name' => 'Exclusive Webinars/Workshops	',
                'subscription_plan_id' => $gold
            ],
            [
                'name' => 'Certificate of Completion	',
                'subscription_plan_id' => $bronze
            ],
            [
                'name' => 'Priority Customer Support	',
                'subscription_plan_id' => $gold
            ],
            [
                'name' => 'Early Access to New Courses	',
                'subscription_plan_id' => $silver
            ],
            [
                'name' => 'Access to Live Sessions	',
                'subscription_plan_id' => $silver
            ],
        ];

        return $sections;
    }
}
