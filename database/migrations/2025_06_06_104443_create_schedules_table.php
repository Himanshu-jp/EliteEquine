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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('product_id')->nullable()->index();
             $table->foreign('user_id', 'schedules_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id', 'schedules_product_id_foreign')->references('id')->on('products')->onDelete('cascade');
            $table->date('service_date')->nullable();
            $table->enum('status', ['0', '1'])->default('0')->comment('0 = unschedule, 1 = schedule');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
