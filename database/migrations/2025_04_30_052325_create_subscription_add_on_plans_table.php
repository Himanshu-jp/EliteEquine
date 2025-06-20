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
        Schema::create('subscription_add_on_plans', function (Blueprint $table) {
            $table->id();
            $table->longText("description");
            $table->enum("type",["boostAd",'socialPost','banner',"emailPromotion","communityPromotion"]);
            $table->decimal("price",11,2);
            $table->integer("days");
           
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_add_on_plans');
    }
};
