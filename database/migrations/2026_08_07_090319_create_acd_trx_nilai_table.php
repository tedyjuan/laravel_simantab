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
            // Siswa
            $table->string('kode_siswa', 30);

            // Mata Pelajaran
            $table->string('kode_mapel', 20);

            // Kelas / Rombel
            $table->string('kode_kelas', 20);

            // Tahun Ajaran
            $table->string('kode_tahun_ajaran', 20);

            // Guru
            $table->string('kode_guru', 30)->nullable();

            // Nilai
            $table->decimal('nilai_akhir', 5, 2)->nullable();

            // Predikat: A, B, C, D
            $table->string('predikat', 5)->nullable();

            // Catatan guru
            $table->text('catatan')->nullable();

            $table->timestamps();

            // 1 siswa hanya punya 1 nilai
            // untuk 1 mapel pada 1 tahun ajaran
            $table->unique([
                'kode_siswa',
                'kode_mapel',
                'kode_tahun_ajaran'
            ], 'uniq_nilai_siswa_mapel_ta');

            // Index
            $table->index([
                'kode_kelas',
                'kode_tahun_ajaran'
            ]);

            $table->index([
                'kode_guru',
                'kode_tahun_ajaran'
            ]);

            $table->index('kode_mapel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_trx_nilai');
    }

    // | kode_siswa | kode_mapel | kode_kelas | kode_tahun_ajaran | kode_guru | nilai_akhir | predikat |
    // | ---------- | ---------- | ---------- | ----------------- | --------- | ----------: | -------- |
    // | STD001     | MTK        | SMP1-A     | 2026/2027         | PGW001    |       88.50 | A        |
    // | STD002     | MTK        | SMP1-A     | 2026/2027         | PGW001    |       75.00 | B        |
    // | STD003     | IPA        | SMP1-A     | 2026/2027         | PGW002    |       92.00 | A        |

};
