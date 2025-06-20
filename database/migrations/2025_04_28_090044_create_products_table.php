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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index();
            $table->foreignId('category_id')->nullable()->index();
            $table->enum("sale_method",['standard',"auction"]);
            $table->enum("return_available",['yes',"no"])->nullable();
            $table->integer("return_days")->nullable();
            $table->string("title")->nullable();
            $table->string("slug")->nullable();
            $table->float("price")->nullable();
            $table->enum("is_negotiable",['yes',"no"])->nullable();
            $table->enum("is_motivated_seller",['yes',"no"])->nullable();
            $table->enum("price_reduced",['yes',"no"])->nullable();
        
            $table->string("currency")->nullable();
            $table->text("description")->nullable();
            $table->enum("transaction_method",['platform',"buyertoseller"])->nullable();
            $table->integer("auc_winner_pay_in")->nullable();
            $table->integer("bid_end_days")->nullable();
            $table->enum("mark_as",['sold','lease','rented'])->nullable();
            $table->string("product_status")->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
