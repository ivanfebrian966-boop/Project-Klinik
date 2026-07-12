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
            $table->string('status')->default('tersedia');
            $table->foreignId('dokter_id')->nullable()->constrained('dokters')->nullOnDelete();
            $table->foreignId('pasien_id')->nullable()->constrained('pasiens')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
