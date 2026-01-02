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
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->enum('type', ['core', 'plugin', 'theme'])->default('plugin');
            $table->string('name');
            $table->string('current_version')->nullable();
            $table->string('new_version');
            $table->enum('status', ['pending', 'scheduled', 'completed', 'failed'])->default('pending');
            $table->text('changelog')->nullable();
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
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
