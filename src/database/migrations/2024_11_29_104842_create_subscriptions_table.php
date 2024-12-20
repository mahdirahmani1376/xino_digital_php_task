<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('subscription_plan_id')
                ->index()
                ->references('id')
                ->on('subscription_plans')
                ->cascadeOnDelete();

            $table
                ->foreignId('user_id')
                ->index()
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
