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
        Schema::create('site_monitors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['up', 'down', 'slow'])->default('up');
            $table->integer('response_time')->nullable(); // in milliseconds
            $table->integer('http_status_code')->nullable();
            $table->float('cpu_usage')->nullable();
            $table->float('memory_usage')->nullable();
            $table->float('disk_usage')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('checked_at');
            $table->timestamps();
            
            $table->index(['site_id', 'checked_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_monitors');
    }
};
