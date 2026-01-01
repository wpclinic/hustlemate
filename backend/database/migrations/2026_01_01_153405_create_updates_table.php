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
        Schema::create('updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->enum('update_type', ['core', 'plugin', 'theme'])->default('plugin');
            $table->string('item_name');
            $table->string('current_version');
            $table->string('latest_version');
            $table->enum('status', ['pending', 'scheduled', 'in_progress', 'completed', 'failed'])->default('pending');
            $table->enum('compatibility_status', ['compatible', 'untested', 'incompatible'])->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('applied_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['site_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('updates');
    }
};
