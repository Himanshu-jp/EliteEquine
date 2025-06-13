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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->index();
            $table->foreignId('height_id')->nullable();
            $table->foreignId('sex_id')->nullable();
            $table->foreignId('green_eligibilitie_id')->nullable();
            $table->dateTime('fromdate')->nullable();
            $table->dateTime('todate')->nullable();          
            $table->integer('bid_min_price')->nullable();
            $table->integer('sale_price')->nullable();
            $table->integer('lease_price')->nullable();
            $table->string('trainer')->nullable();
            $table->integer('sleeps')->nullable();
            $table->string('facility')->nullable();
            $table->string('sirebloodline')->nullable();
            $table->string('dambloodline')->nullable();
            $table->string('usef')->nullable();
            $table->string('pedigree_chart')->nullable();
            $table->string('around')->nullable();  
            $table->integer('age')->nullable();
            $table->string('fromlocation')->nullable();
            $table->string('tolocation')->nullable();
            $table->integer('price')->nullable();
            $table->integer('hourly_price')->nullable();
            $table->integer('fixed_price')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('precise_location')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('banner')->nullable();
            $table->string('agree')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
