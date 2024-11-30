<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Invoice;
use App\Enums\InvoiceEnum;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Enums\TransactionEnum;
use App\Models\SubscriptionPlan;
use Database\Seeders\SubscriptionPlanSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentTest extends TestCase
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

        $response = $this->actingAs($subscription->user)->postJson(route('payment.webhook', $data));

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

    public function test_create_plan(): void
    {
        $subscription = Subscription::factory()->create();
        $subscription->user->update([
            'subscription_id' => $subscription->id
        ]);

        $response = $this->actingAs($subscription->user)->postJson(route('payment.create-plan',[
            'subscription_id' => $subscription->id,
        ]));

        $response->assertStatus(200);

    }

    public function test_an_invoice_can_be_created()
    {
        $user = User::factory()->create();
        $subPlan = SubscriptionPlan::inRandomOrder()->first();

        $response = $this->actingAs($user)->postJson(route('invoices.store',[
            'subscription_plan_id' => $subPlan->id
        ]));

        dump($response->json());

        $response->assertStatus(200);

        $this->assertDatabaseHas('invoices',[
            'user_id' => $user->id,
            'amount' => $subPlan->price
        ]);

        
    }

    public function test_an_invoice_can_be_paid()
    {
        $user = User::factory()->create();
        $susbcriptionPlan = SubscriptionPlan::inRandomOrder()->first();
        $invoice = Invoice::factory()->create([
            "user_id" => $user->id,
            "amount" => $susbcriptionPlan->price,
            "status" => InvoiceEnum::UNPAID,
        ]);

        $response = $this->actingAs($user)->postJson(route('invoices.pay',$invoice));

        $response->assertStatus(200);

        $this->assertDatabaseHas('transactions',[
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount,
            'status' => TransactionEnum::PENDING
        ]);
    }

    public function test_on_successful_callback()
    {
        $user = User::factory()->create();
        $susbcriptionPlan = SubscriptionPlan::inRandomOrder()->first();

        $invoice = Invoice::factory()->create([
            "user_id" => $user->id,
            "amount" => $susbcriptionPlan->price,
            "status" => InvoiceEnum::UNPAID,
        ]);

        $item = Item::create([
            "subscription_plan_id" => $susbcriptionPlan->id,
            "amount" => $invoice->amount,
            "invoice_id" => $invoice->id,
        ]);
        
        $traceId = 'test';

        $transaction = Transaction::create([
            'invoice_id' => $invoice->id,
            'amount' => $invoice->amount,
            'trace_id' => $traceId,
            'status' => TransactionEnum::PENDING
        ]);

        $response = $this->actingAs($user)->getJson(route('payment.success',[
            'paymentId' => $traceId
        ]));

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions',[
            "subscription_plan_id" => $susbcriptionPlan->id,
            "user_id" => $user->id,
            "expired_at" => now()->addMonth(),
        ]);

        $this->assertDatabaseHas('invoices',[
            "id" => $invoice->id,
            'status' => InvoiceEnum::PAID,
        ]);

        $this->assertDatabaseHas('transactions',[
            "id" => $transaction->id,
            'status' => TransactionEnum::SUCCESS,
        ]);

    }

    
}
