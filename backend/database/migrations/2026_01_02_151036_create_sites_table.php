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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->string('name');
            $table->string('url');
            $table->string('wp_version')->nullable();
            $table->string('php_version')->nullable();
            $table->enum('status', ['online', 'offline', 'warning', 'maintenance'])->default('online');
            $table->decimal('uptime_percentage', 5, 2)->default(100);
            $table->integer('response_time')->nullable(); // in milliseconds
            $table->timestamp('last_checked_at')->nullable();
            $table->string('api_key', 64)->unique();
            $table->boolean('monitoring_enabled')->default(true);
            $table->boolean('backup_enabled')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
