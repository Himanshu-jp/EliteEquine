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
            $table->text('username')
                ->after('password')
                ->nullable();

            $table->enum('opt_in_notification', ['no', 'yes'])
                ->default("no")
                ->after('two_factor_secret');

            $table->text('phone_no')
                ->after('opt_in_notification')
                ->nullable();

            $table->text('bio')
                ->after('phone_no')
                ->nullable();
            $table->text('country')
                ->after('bio')
                ->nullable();
            $table->text('state')
                ->after('country')
                ->nullable();
            $table->text('city')
                ->after('state')
                ->nullable();
            $table->text('street')
                ->after('city')
                ->nullable();        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'opt_in_notification',
                'phone_no',
                'country',
                'state',
                'city',
                'street',
            ]);
        });
    }
};
