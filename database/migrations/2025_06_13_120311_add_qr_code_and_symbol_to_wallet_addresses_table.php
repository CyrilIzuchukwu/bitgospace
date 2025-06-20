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
        Schema::table('wallet_addresses', function (Blueprint $table) {
            //
            $table->string('qr_code')->nullable()->after('address'); // path or URL to the QR code image
            $table->string('symbol')->nullable()->after('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_addresses', function (Blueprint $table) {
            //
            $table->dropColumn(['qr_code', 'symbol']);
        });
    }
};
