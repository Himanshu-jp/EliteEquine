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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('convenience_id');
            $table->unsignedBigInteger('chat_user_id');
            $table->unsignedBigInteger('from_id');
            $table->unsignedBigInteger('to_id')->nullable();
            $table->unsignedBigInteger('replay_id')->default(0);
            $table->text('message')->nullable();
            $table->string('file', 255)->nullable();
            $table->string('file_type', 255)->nullable();
            $table->string('thumbnail', 255)->nullable();
            $table->string('is_read', 255)->default('0');
            $table->string('is_clear', 255)->default('0');
            $table->timestamps();
            $table->softDeletes();
        });       
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
