<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_trx_anggota_rombel', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            // Siswa
            $table->string('nis', 30);

            // Rombel
            $table->string('kode_rombel', 20);

            // Tahun Ajaran
            $table->string('kode_tahun_ajaran', 20);

            $table->enum('status', [
                'aktif',
                'pindah',
                'keluar'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            // 1 siswa hanya boleh di 1 rombel per tahun ajaran
            $table->unique([
                'nis',
                'kode_rombel',
                'kode_tahun_ajaran'
            ], 'uniq_anggota_rombel');

            // Foreign Keys
            $table->foreign('nis')
                ->references('nis')
                ->on('std_ms_siswa')
                ->restrictOnDelete();

            $table->foreign('kode_rombel')
                ->references('kode_rombel')
                ->on('acd_ms_rombel')
                ->restrictOnDelete();

            $table->foreign('kode_tahun_ajaran')
                ->references('kode_tahun_ajaran')
                ->on('acd_ms_tahun_ajaran')
                ->restrictOnDelete();

            $table->index(['kode_rombel', 'kode_tahun_ajaran']);
            $table->index(['nis', 'kode_tahun_ajaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_trx_anggota_rombel');
    }
};
