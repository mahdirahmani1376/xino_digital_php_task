<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void{
        parent::setUp();
        $this->seed();
    }

    public function test_webhook(): void
    {
        

        $response = $this->get(route('payment.webhook'));

        $response->assertStatus(200);
    }
}
