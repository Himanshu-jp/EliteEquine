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
        Schema::create('seller_businesses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();

            // Listing Section
            $table->string('listing_icon')->nullable();
            $table->string('listing_title')->nullable();
            $table->text('listing_content')->nullable();

            // Track Section
            $table->string('track_icon')->nullable();
            $table->string('track_title')->nullable();
            $table->text('track_content')->nullable();

            // Featured Section
            $table->string('featured_icon')->nullable();
            $table->string('featured_title')->nullable();
            $table->text('featured_content')->nullable();

            // Post Section
            $table->string('post_icon')->nullable();
            $table->string('post_title')->nullable();
            $table->text('post_content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_businesses');
    }
};
