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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->decimal('price',11, 2)->nullable();
            $table->string('currency', 20)->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_payment_intent')->nullable();
            $table->string('payment_status', 20)->nullable();
            $table->enum('order_status', ['pending', 'complete', 'process'])->default('pending')->comment('order delivery status');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id', 'orders_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id', 'orders_product_id_foreign')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
