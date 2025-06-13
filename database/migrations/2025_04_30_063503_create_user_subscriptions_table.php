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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('subscription_id')->nullable()->index();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('txn_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id', 'user_subscriptions_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('subscription_id', 'user_subscriptions_subscription_id_foreign')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
