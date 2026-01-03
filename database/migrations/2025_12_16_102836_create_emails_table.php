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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('email_title');
            $table->text('email_content');
            $table->enum('user_type', ['all', 'single']);
            $table->string('recipient_email')->nullable(); // For single user
            $table->json('attachments')->nullable();
            $table->unsignedBigInteger('sent_by');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->foreign('sent_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
