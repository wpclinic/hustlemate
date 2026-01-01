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
            $table->foreignId('site_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['daily', 'weekly', 'monthly', 'custom'])->default('weekly');
            $table->text('summary')->nullable();
            $table->json('data')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamp('period_start');
            $table->timestamp('period_end');
            $table->timestamp('generated_at')->nullable();
            $table->timestamps();
            
            $table->index(['client_id', 'created_at']);
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
