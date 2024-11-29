<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Section;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Database\Seeders\SectionSeeder;
use Database\Seeders\SubscriptionPlanSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(SubscriptionPlanSeeder::class);
        $this->seed(SectionSeeder::class);
    }

    public function test_bronze_user_can_see_a_course(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(
            [
                'user_id' => $user->id,
                'subscription_plan_id' => SubscriptionPlan::firstWhere('name','bronze')->first()->id,
            ]
        );
        $user->update([
            'subscription_id' => $subscription->id
        ]);

        $response = $this->actingAs($user)->getjson(route('course.view_course'));

        $response->assertStatus(200);
    }
}
