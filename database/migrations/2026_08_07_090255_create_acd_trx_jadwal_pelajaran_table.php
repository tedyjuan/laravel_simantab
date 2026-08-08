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

            $table->foreignId('id_kelas')
                ->constrained('acd_ms_kelas')
                ->cascadeOnDelete();

            $table->foreignId('id_mapel')
                ->constrained('acd_ms_mapel')
                ->restrictOnDelete();

            $table->foreignId('id_guru')
                ->constrained('hr_ms_pegawai')
                ->restrictOnDelete();

            $table->foreignId('id_tahun_ajaran')
                ->constrained('acd_ms_tahun_ajaran')
                ->cascadeOnDelete();

            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan', 50)->nullable();

            $table->timestamps();

            $table->index(['id_kelas', 'hari']);
            $table->index(['id_guru', 'hari']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_trx_jadwal_pelajaran');
    }
};
