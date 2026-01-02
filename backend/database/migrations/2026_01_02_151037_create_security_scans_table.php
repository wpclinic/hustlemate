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
            $table->foreignId('site_id')->constrained('sites')->onDelete('cascade');
            $table->enum('status', ['clean', 'warning', 'infected', 'scanning'])->default('scanning');
            $table->integer('threats_found')->default(0);
            $table->json('scan_results')->nullable();
            $table->text('recommendations')->nullable();
            $table->timestamp('scanned_at');
            $table->timestamps();
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
