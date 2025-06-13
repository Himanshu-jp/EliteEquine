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
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('last_name')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->string('is_hide_phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->string('last_name')->nullable(false)->change();
            $table->string('phone')->nullable(false)->change();
            $table->string('is_hide_phone')->nullable(false)->change();
        });
    }
};
