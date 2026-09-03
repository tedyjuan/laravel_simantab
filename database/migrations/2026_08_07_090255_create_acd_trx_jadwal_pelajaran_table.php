<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_trx_jadwal_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            // Rombel (bukan kelas — jadwal per rombel)
            $table->string('kode_rombel', 20);

            // Mata Pelajaran
            $table->string('kode_mapel', 20);

            // Guru / Pegawai
            $table->string('kode_pegawai', 30);

            // Tahun Ajaran
            $table->string('kode_tahun_ajaran', 20);

            // Jadwal
            $table->enum('hari', [
                'senin',
                'selasa',
                'rabu',
                'kamis',
                'jumat',
                'sabtu'
            ]);

            $table->time('jam_mulai');
            $table->time('jam_selesai');

            // Ruangan
            $table->string('kode_ruangan', 20)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('kode_rombel')
                ->references('kode_rombel')
                ->on('acd_ms_rombel')
                ->restrictOnDelete();

            $table->foreign('kode_mapel')
                ->references('kode_mapel')
                ->on('acd_ms_mapel')
                ->restrictOnDelete();

            $table->foreign('kode_pegawai')
                ->references('kode_pegawai')
                ->on('hr_ms_pegawai')
                ->restrictOnDelete();

            $table->foreign('kode_tahun_ajaran')
                ->references('kode_tahun_ajaran')
                ->on('acd_ms_tahun_ajaran')
                ->restrictOnDelete();

            $table->foreign('kode_ruangan')
                ->references('kode_ruangan')
                ->on('inv_ms_ruangan')
                ->nullOnDelete();

            // Index
            $table->index([
                'kode_rombel',
                'hari'
            ]);

            $table->index([
                'kode_pegawai',
                'hari'
            ]);

            $table->index('kode_tahun_ajaran');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_trx_jadwal_pelajaran');
    }
};
