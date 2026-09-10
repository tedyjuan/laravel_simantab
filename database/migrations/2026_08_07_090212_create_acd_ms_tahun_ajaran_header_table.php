<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_tahun_ajaran_header', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            // contoh: TAI001
            $table->string('kode_tahun_ajaran_header', 20)->nullable()->unique();

            // contoh: Tahun Ajaran 2025/2026
            $table->string('nama_tahun_ajaran_header', 50);

            $table->year('tahun_mulai');   // simpan cuma 2025
            $table->year('tahun_selesai'); // simpan cuma 2026

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('nonaktif');
            $table->timestamps();
            $table->softDeletes();
            // Index buat pencarian cepat berdasarkan tahun
            $table->index(['tahun_mulai', 'tahun_selesai']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_tahun_ajaran_header');
    }
};
