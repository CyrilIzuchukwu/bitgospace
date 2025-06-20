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
        Schema::create('deposit_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('deposit_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('amount', 16, 8);
            $table->decimal('crypto_amount', 16, 8);
            $table->string('currency', 10);
            $table->string('type'); // deposit, withdrawal, etc.
            $table->string('status'); // pending, completed, failed
            $table->text('description')->nullable();
            $table->string('tx_hash')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposit_transactions');
    }
};
