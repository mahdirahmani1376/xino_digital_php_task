<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Invoice;
use App\Enums\InvoiceEnum;
use App\Models\Subscription;
use Database\Seeders\SubscriptionPlanSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void{
        parent::setUp();
        $this->seed(SubscriptionPlanSeeder::class);
    }

    public function test_webhook(): void
    {
        $subscription = Subscription::factory()->create();
        $subscription->user->update([
            'subscription_id' => $subscription->id
        ]);

        $data = [
            'id' => $subscription->id,
            'paymentId' => 11223344
        ];

        $response = $this->postJson(route('payment.webhook', $data));

        $this->assertDatabaseHas('subscriptions',[
            'expired_at' => now()->addMonth(),
            'user_id' => $subscription->user->id,
        ]);

        $this->assertDatabaseHas('invoices',[
            'amount' => $subscription->subscriptionPlan->price,
            'user_id' =>   $subscription->user->id,
            'status' => InvoiceEnum::PAID
        ]);

        $response->assertStatus(200);
    }
}
