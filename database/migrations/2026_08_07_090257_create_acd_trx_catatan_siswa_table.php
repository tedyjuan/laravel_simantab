<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_trx_catatan_siswa', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            // Siswa
            $table->string('nis', 30);

            // Pencatat (guru / wali kelas / BK)
            $table->string('kode_pegawai', 30);

            // Tahun Ajaran
            $table->string('kode_tahun_ajaran', 20);

            $table->enum('jenis', [
                'akademik',
                'perilaku',
                'konseling',
                'prestasi'
            ]);

            $table->string('judul', 200);
            $table->text('isi');
            $table->date('tanggal');

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('nis')
                ->references('nis')
                ->on('std_ms_siswa')
                ->restrictOnDelete();

            $table->foreign('kode_pegawai')
                ->references('kode_pegawai')
                ->on('hr_ms_pegawai')
                ->restrictOnDelete();

            $table->foreign('kode_tahun_ajaran')
                ->references('kode_tahun_ajaran')
                ->on('acd_ms_tahun_ajaran')
                ->restrictOnDelete();

            $table->index(['nis', 'kode_tahun_ajaran']);
            $table->index(['kode_pegawai', 'kode_tahun_ajaran']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_trx_catatan_siswa');
    }
};
