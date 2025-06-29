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
            //
            $table->string('password_reset_token', 100)->nullable();
            $table->string('password_reset_otp')->nullable();
            $table->timestamp('password_reset_token_expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn([
                'password_reset_token',
                'password_reset_otp',
                'password_reset_token_expires_at',
            ]);
        });
    }
};
