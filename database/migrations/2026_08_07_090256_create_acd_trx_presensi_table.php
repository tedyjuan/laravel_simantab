<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_trx_presensi', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            // Siswa
            $table->string('nis', 30);

            // Rombel
            $table->string('kode_rombel', 20);

            // Tahun Ajaran
            $table->string('kode_tahun_ajaran', 20);

            $table->date('tanggal');

            $table->enum('status', [
                'hadir',
                'sakit',
                'izin',
                'alpha'
            ])->default('hadir');

            $table->text('keterangan')->nullable();

            $table->timestamps();

            // 1 siswa hanya punya 1 presensi per hari
            $table->unique(['nis', 'tanggal'], 'uniq_presensi_siswa_tanggal');

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

            $table->index(['kode_rombel', 'tanggal']);
            $table->index(['kode_tahun_ajaran', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_trx_presensi');
    }
};
