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
        Schema::create('user_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('given_by')->nullable()->index();
            $table->string('comment');
            $table->string('image');
            $table->decimal('rating', 8, 2);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id', 'user_ratings_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('given_by', 'user_ratings_given_by_foreign')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_ratings');
    }
};
