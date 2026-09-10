<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_tahun_ajaran_detail', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            $table->string('kode_tahun_ajaran_detail', 20)->nullable()->unique();

            // Relasi ke acd_ms_tahun_ajaran_header
            $table->string('kode_tahun_ajaran_header', 20)->nullable();

            $table->string('nama_tahun_ajaran_detail', 50);
            $table->enum('semester', ['ganjil', 'genap']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('nonaktif');

            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('kode_tahun_ajaran_header')
                ->references('kode_tahun_ajaran_header')
                ->on('acd_ms_tahun_ajaran_header')
                ->restrictOnDelete();

            // Kasih nama custom yang pendek, biar gak kena limit 64 karakter
            $table->index(
                ['kode_tahun_ajaran_header', 'semester', 'status'],
                'idx_tad_header_semester_status'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_tahun_ajaran_detail');
    }
};
