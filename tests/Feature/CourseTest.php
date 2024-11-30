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

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(SubscriptionPlanSeeder::class);
        $this->seed(SectionSeeder::class);
    }

    public function test_bronze_user_abilites(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(
            [
                'user_id' => $user->id,
                'subscription_plan_id' => SubscriptionPlan::firstWhere('name','bronze')->id,
            ]
        );
        $user->update([
            'subscription_id' => $subscription->id
        ]);

        $this->actingAs($user);

        $responseBronze = $this->getjson(route('course.view_course'));

        $responseBronze->assertStatus(200);

        $responseSilver = $this->getJson(route('course.download_course'));

        $responseSilver->assertStatus(403);

        $responseGold = $this->getJson(route('course.send_direct_messages_to_mentor'));

        $responseGold->assertStatus(403);
        
    }

    public function test_silver_user_abilites(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(
            [
                'user_id' => $user->id,
                'subscription_plan_id' => SubscriptionPlan::firstWhere('name','=','silver')->id,
            ]
        );

        $user->update([
            'subscription_id' => $subscription->id
        ]);

        $this->actingAs($user);

        $responseBronze = $this->getjson(route('course.view_course'));

        $responseBronze->assertStatus(200);

        $responseSilver = $this->getJson(route('course.download_course'));

        $responseSilver->assertStatus(200);

        $responseGold = $this->getJson(route('course.send_direct_messages_to_mentor'));

        $responseGold->assertStatus(403);
        
    }

    public function test_gold_user_abilites(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(
            [
                'user_id' => $user->id,
                'subscription_plan_id' => SubscriptionPlan::firstWhere('name','gold')->id,
            ]
        );
        $user->update([
            'subscription_id' => $subscription->id
        ]);

        $this->actingAs($user);

        $responseBronze = $this->getjson(route('course.view_course'));

        $responseBronze->assertStatus(200);

        $responseSilver = $this->getJson(route('course.download_course'));

        $responseSilver->assertStatus(200);

        $responseGold = $this->getJson(route('course.send_direct_messages_to_mentor'));

        $responseGold->assertStatus(200);
        
    }

    public function test_user_with_expired_section_can_not_access_content(): void
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(
            [
                'user_id' => $user->id,
                'subscription_plan_id' => SubscriptionPlan::firstWhere('name','gold')->id,
                'expired_at' => now()->subDays(40)
            ]
        );
        $user->update([
            'subscription_id' => $subscription->id
        ]);

        $this->actingAs($user);

        $responseBronze = $this->getjson(route('course.view_course'));

        $responseBronze->assertStatus(403);

        $responseSilver = $this->getJson(route('course.download_course'));

        $responseSilver->assertStatus(403);

        $responseGold = $this->getJson(route('course.send_direct_messages_to_mentor'));

        $responseGold->assertStatus(403);
    }
}
