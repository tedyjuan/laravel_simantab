<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_trx_nilai', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            // Siswa (menggunakan NIS sebagai business key)
            $table->string('nis', 30);

            // Mata Pelajaran
            $table->string('kode_mapel', 20);

            // Rombel (bukan kelas)
            $table->string('kode_rombel', 20);

            // Tahun Ajaran
            $table->string('kode_tahun_ajaran', 20);

            // Guru yang menilai
            $table->string('kode_pegawai', 30)->nullable();

            // Nilai
            $table->decimal('nilai_akhir', 5, 2)->nullable();

            // Predikat: A, B, C, D
            $table->string('predikat', 5)->nullable();

            // Catatan guru
            $table->text('catatan')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // 1 siswa hanya punya 1 nilai
            // untuk 1 mapel pada 1 tahun ajaran
            $table->unique([
                'nis',
                'kode_mapel',
                'kode_tahun_ajaran'
            ], 'uniq_nilai_siswa_mapel_ta');

            // Foreign Keys
            $table->foreign('nis')
                ->references('nis')
                ->on('std_ms_siswa')
                ->restrictOnDelete();

            $table->foreign('kode_mapel')
                ->references('kode_mapel')
                ->on('acd_ms_mapel')
                ->restrictOnDelete();

            $table->foreign('kode_rombel')
                ->references('kode_rombel')
                ->on('acd_ms_rombel')
                ->restrictOnDelete();

            $table->foreign('kode_tahun_ajaran')
                ->references('kode_tahun_ajaran')
                ->on('acd_ms_tahun_ajaran')
                ->restrictOnDelete();

            $table->foreign('kode_pegawai')
                ->references('kode_pegawai')
                ->on('hr_ms_pegawai')
                ->nullOnDelete();

            // Index
            $table->index([
                'kode_rombel',
                'kode_tahun_ajaran'
            ]);

            $table->index([
                'kode_pegawai',
                'kode_tahun_ajaran'
            ]);

            $table->index('kode_mapel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_trx_nilai');
    }

    // | nis    | kode_mapel | kode_rombel | kode_tahun_ajaran | kode_pegawai | nilai_akhir | predikat |
    // | ------ | ---------- | ----------- | ----------------- | ------------ | ----------: | -------- |
    // | STD001 | MTK        | SMP1-A      | 2026/2027-1       | PGW001       |       88.50 | A        |
    // | STD002 | MTK        | SMP1-A      | 2026/2027-1       | PGW001       |       75.00 | B        |
    // | STD003 | IPA        | SMP1-A      | 2026/2027-1       | PGW002       |       92.00 | A        |

};
