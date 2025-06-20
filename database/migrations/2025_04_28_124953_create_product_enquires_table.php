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
        Schema::create('product_enquires', function (Blueprint $table) {
            $table->id();
          
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('name');
            $table->string('email');
            $table->text('message');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id', 'product_enquires_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id', 'product_enquires_product_id_foreign')->references('id')->on('products')->onDelete('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_enquires');
    }
};
