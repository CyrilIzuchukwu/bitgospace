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
        Schema::create('kyc_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Verification Details
            $table->enum('status', ['pending', 'approved', 'rejected', 'in_review'])->default('pending');
            $table->text('rejection_reason')->nullable();

            // Document Information
            $table->enum('document_type', ['id_card', 'passport', 'driver_license'])->nullable();
            $table->string('country')->nullable();
            $table->string('country_flag')->nullable();


            // Timestamps
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();

            // Document Images
            $table->string('front_image_path');
            $table->string('back_image_path')->nullable();
            $table->string('selfie_image_path');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_verifications');
    }
};
