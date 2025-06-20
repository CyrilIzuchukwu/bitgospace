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
        Schema::create('referral_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users');
            $table->foreignId('investor_id')->constrained('users');
            $table->foreignId('investment_id')->constrained('investments');
            $table->tinyInteger('level'); // 1, 2, or 3
            $table->decimal('amount', 15, 2);
            $table->decimal('percentage', 5, 2); // stores the percentage (10.00, 4.00, etc.)
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_commissions');
    }
};
