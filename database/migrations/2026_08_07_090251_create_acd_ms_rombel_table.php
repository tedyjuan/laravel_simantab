<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_rombel', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            $table->string('kode_rombel', 20)->nullable()->unique();
            $table->string('nama_rombel', 50);

            // Relasi ke acd_ms_kelas
            $table->string('kode_kelas', 20);

            // Relasi ke acd_ms_tahun_ajaran_header (bukan acd_ms_tahun_ajaran lagi)
            $table->string('kode_tahun_ajaran_header', 20);

            // Wali kelas relasi ke hr_ms_pegawai
            $table->string('kode_pegawai', 30)->nullable();

            $table->unsignedSmallInteger('kapasitas')->default(30);

            // Ruangan, relasi ke inv_ms_ruangan
            $table->string('kode_ruangan', 20)->nullable();

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('kode_kelas')
                ->references('kode_kelas')
                ->on('acd_ms_kelas')
                ->restrictOnDelete();

            $table->foreign('kode_tahun_ajaran_header')
                ->references('kode_tahun_ajaran_header')
                ->on('acd_ms_tahun_ajaran_header')
                ->restrictOnDelete();

            $table->foreign('kode_pegawai')
                ->references('kode_pegawai')
                ->on('hr_ms_pegawai')
                ->nullOnDelete();

            $table->foreign('kode_ruangan')
                ->references('kode_ruangan')
                ->on('inv_ms_ruangan')
                ->nullOnDelete();

            // Index custom (nama pendek, hindari error 64 karakter kayak sebelumnya)
            $table->index(
                ['kode_kelas', 'kode_tahun_ajaran_header', 'status'],
                'idx_rombel_kelas_tahun_status'
            );

            $table->unique(
                ['nama_rombel', 'kode_kelas', 'kode_tahun_ajaran_header'],
                'uniq_rombel_kelas_tahun'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_rombel');
    }
};
