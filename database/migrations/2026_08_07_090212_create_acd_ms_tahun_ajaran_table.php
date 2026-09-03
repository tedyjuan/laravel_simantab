<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_tahun_ajaran', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('kode_tahun_ajaran', 20)->nullable()->unique(); // contoh: 2025/2026-1
            $table->string('nama', 50); // contoh: Tahun Ajaran 2025/2026 Ganjil
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('nonaktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_tahun_ajaran');
    }
};
