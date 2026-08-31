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
            // Kelas
            $table->string('kode_kelas', 20);

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

            $table->string('ruangan', 50)->nullable();

            $table->timestamps();

            // Index
            $table->index([
                'kode_kelas',
                'hari'
            ]);

            $table->index([
                'kode_pegawai',
                'hari'
            ]);

            $table->index([
                'kode_mapel',
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
