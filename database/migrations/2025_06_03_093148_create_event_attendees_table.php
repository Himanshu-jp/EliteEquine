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
        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('event_id')->nullable()->index();
            $table->integer('amount');
            $table->string('currency')->default('usd');
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('stripe_session_id')->nullable(); // to store Stripe session ID
            $table->string('stripe_payment_intent')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
    }
};
