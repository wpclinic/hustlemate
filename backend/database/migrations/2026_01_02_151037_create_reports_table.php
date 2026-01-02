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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('site_id')->nullable()->constrained('sites')->onDelete('set null');
            $table->string('type'); // e.g., 'weekly', 'monthly', 'custom'
            $table->string('title');
            $table->json('data')->nullable();
            $table->enum('status', ['pending', 'generated', 'sent', 'failed'])->default('pending');
            $table->string('file_path')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
