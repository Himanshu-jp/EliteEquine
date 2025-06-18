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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('session_id')->nullable();
            $table->string('plan_purchase_on')->nullable();
            $table->string('next_renewal_date')->nullable();
            $table->string('expired_on')->nullable();
            $table->string('cancelled')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('plan_price')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('subscription_id')->nullable();
            $table->longText('response_data')->nullable();
            $table->string('status', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
