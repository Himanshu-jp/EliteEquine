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
        Schema::table('users', function (Blueprint $table) {
            $table->string('stripe_id')->nullable();
            $table->boolean('is_subscribed')->default(0);
            $table->string('plan_activated_on')->nullable();
            $table->string('plan_expired_on')->nullable();
            $table->string('plan_id')->nullable();
            $table->string('subscription_id')->nullable();
            $table->longText('stripe_connect_data')->nullable();
            $table->integer('avgRating')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['stripe_id','is_subscribed','plan_activated_on','plan_expired_on','plan_id','subscription_id','stripe_connect_data','avgRating']);
        });
    }
};
