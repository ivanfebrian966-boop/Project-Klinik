<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('jam');
            $table->enum('status', ['tersedia', 'dipesan', 'selesai'])->default('tersedia');
            $table->timestamp('tanggal_booking')->nullable();
            $table->foreignId('dokter_id')->nullable()->constrained('dokters')->nullOnDelete();
            $table->foreignId('pasien_id')->nullable()->constrained('pasiens')->nullOnDelete();
            $table->timestamps();

            $table->index(['tanggal', 'status']);
            $table->index(['dokter_id', 'pasien_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
