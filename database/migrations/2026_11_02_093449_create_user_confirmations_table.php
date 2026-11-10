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
        Schema::create('user_confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('token', 64)->unique();
            $table->timestamp('expires_at');
            $table->enum('decision', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_confirmations');
    }
};
