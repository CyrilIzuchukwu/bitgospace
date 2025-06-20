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
        Schema::table('wallets', function (Blueprint $table) {
            $table->string('otp_pin')->nullable()->after('pin_set');
            $table->string('otp_pin_token')->nullable()->after('otp_pin');
            $table->timestamp('otp_pin_expires_at')->nullable()->after('otp_pin_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn(['otp_pin', 'otp_pin_token', 'otp_pin_expires_at']);
        });
    }
};
