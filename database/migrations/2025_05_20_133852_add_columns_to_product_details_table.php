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
        Schema::table('product_details', function (Blueprint $table) {
            $table->integer('stalls_available')->nullable();
            $table->integer('daily_board_rental_rate')->nullable();
            $table->integer('monthly_board_rental_rate')->nullable();
            $table->integer('weekly_board_rental_rate')->nullable();
            $table->integer('sale_cost')->nullable();
            $table->integer('salary')->nullable();
            $table->string('haulings_location_from')->nullable();
            $table->string('haulings_location_to')->nullable();
            $table->integer('stalls_available_haulings')->nullable();
            $table->string('realtor')->nullable();
            $table->string('property_manager')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_details', function (Blueprint $table) {
            $table->dropColumn(['stalls_available', 'daily_board_rental_rate', 'monthly_board_rental_rate', 'weekly_board_rental_rate', 'sale_cost', 'salary', 'haulings_location_from', 'haulings_location_to', 'stalls_available_haulings','realtor','property_manager']);
        });
    }
};
