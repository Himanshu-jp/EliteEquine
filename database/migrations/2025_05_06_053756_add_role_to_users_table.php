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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role')->nullable()->after('email');
            $table->boolean('sms_notification')->after('social_id')->default(0);
            $table->boolean('mail_notification')->after('sms_notification')->default(0);
            $table->boolean('mobile_notification')->after('mail_notification')->default(0);
            $table->boolean('is_online')->default(0);
            $table->string('socket_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('sms_notification');
            $table->dropColumn('mail_notification');
            $table->dropColumn('mobile_notification');
            $table->dropColumn('is_online');
            $table->dropColumn('socket_id');
        });
    }
};
