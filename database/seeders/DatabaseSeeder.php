<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $postmanTestUser = User::factory()->create([
            'email' => 'test@test.com',
            'password' => '1234',
            'subscription_id' => null,
        ]);

        User::factory(20)->create();

        $this->call([
            SubscriptionPlanSeeder::class,
            SectionSeeder::class,
            SubscriptionSeeder::class,
        ]);
    }
}
