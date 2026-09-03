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

            $table->string('kode_rombel', 20)->unique();
            $table->string('nama_rombel', 50);

            // relasi ke acd_ms_kelas
            $table->string('kode_kelas', 20);

            // relasi ke acd_ms_tahun_ajaran
            $table->string('kode_tahun_ajaran', 20);

            // Wali kelas relasi ke hr_ms_pegawai
            $table->string('kode_pegawai', 30)->nullable();

            // Kapasitas rombel
            $table->unsignedSmallInteger('kapasitas')->default(30);

            // Ruangan , relasi ke inv_ms_ruangan
            $table->string('kode_ruangan', 20)->nullable();

            // Ruangan , relasi ke inv_ms_gedung
            $table->string('kode_gedung', 20)->nullable();

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'kode_kelas',
                'kode_tahun_ajaran',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_rombel');
    }
};
