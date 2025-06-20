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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->decimal('minimum_amount', 15, 2);
            $table->decimal('maximum_amount', 15, 2);
            $table->float('interest_rate', 5, 2);
            $table->integer('duration');
            $table->enum('duration_type', ['days', 'months', 'years'])->default('months');
            $table->enum('payout_frequency', ['daily', 'weekly', 'monthly', 'end_of_term'])->default('end_of_term');
            $table->json('privileges')->nullable();
            $table->float('amount_earned')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
