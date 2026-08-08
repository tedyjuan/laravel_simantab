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

            $table->foreignId('id_siswa')
                ->constrained('std_ms_siswa')
                ->cascadeOnDelete();

            $table->foreignId('id_mapel')
                ->constrained('acd_ms_mapel')
                ->restrictOnDelete();

            $table->foreignId('id_kelas')
                ->constrained('acd_ms_kelas')
                ->restrictOnDelete();

            $table->foreignId('id_tahun_ajaran')
                ->constrained('acd_ms_tahun_ajaran')
                ->restrictOnDelete();

            $table->foreignId('id_guru')
                ->nullable()
                ->constrained('hr_ms_pegawai')
                ->nullOnDelete();

            $table->decimal('nilai_akhir', 5, 2)->nullable(); // hasil akhir dari komponen
            $table->string('predikat', 5)->nullable(); // A, B, C, dst (opsional, bisa dihitung)
            $table->text('catatan')->nullable();

            $table->timestamps();

            // 1 siswa hanya punya 1 record nilai per mapel per tahun ajaran
            $table->unique(['id_siswa', 'id_mapel', 'id_tahun_ajaran'], 'uniq_nilai_siswa_mapel_ta');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_trx_nilai');
    }
};
