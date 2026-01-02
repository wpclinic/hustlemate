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
        Schema::create('security_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->enum('scan_type', ['malware', 'vulnerability', 'ssl', 'firewall'])->default('malware');
            $table->enum('status', ['clean', 'warning', 'critical'])->default('clean');
            $table->integer('threats_found')->default(0);
            $table->json('threats')->nullable();
            $table->text('ssl_info')->nullable();
            $table->timestamp('scanned_at');
            $table->timestamps();
            
            $table->index(['site_id', 'scanned_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_scans');
    }
};
