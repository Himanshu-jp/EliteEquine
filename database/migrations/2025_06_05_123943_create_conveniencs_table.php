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
        Schema::create('conveniencs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('userid')->default('0');
            $table->integer('ticket_id')->default(0);
            $table->string('ticket_type', 50)->nullable();
            $table->string('group_name')->nullable();
            $table->string('group_image')->nullable();
            $table->enum('type', ['SINGLE', 'GROUP'])->default('SINGLE');
            $table->text('last_message')->nullable();
            $table->string('is_block')->default('0');
            $table->string('is_block_user_id')->nullable();       
            $table->softDeletes();     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conveniencs');
    }
};
