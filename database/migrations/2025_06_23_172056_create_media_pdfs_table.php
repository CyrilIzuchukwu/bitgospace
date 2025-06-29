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
        Schema::create('media_pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->enum('type', ['overview', 'bot'])->nullable();
            $table->string('pdf_path');
            $table->string('reference_id')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_pdfs');
    }
};
