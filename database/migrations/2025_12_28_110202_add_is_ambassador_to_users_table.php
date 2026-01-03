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
            $table->boolean('is_ambassador')->default(false)->after('active');
            $table->enum('ambassador_request_status', ['none', 'pending', 'approved', 'rejected'])->default('none')->after('is_ambassador');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_ambassador', 'ambassador_request_status']);
        });
    }
};
