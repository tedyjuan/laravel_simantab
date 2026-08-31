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
            // Identitas rombel
            $table->string('kode_rombel', 50)->unique();
            $table->string('nama_rombel', 100);

            // Relasi menggunakan kode
            $table->string('kode_tahun_ajaran', 50);
            $table->string('kode_kelas', 50);

            // Opsional 
            $table->string('kode_ruangan', 50)->nullable();
            $table->string('kode_wali_kelas', 50)->nullable();

            // Kapasitas siswa
            $table->unsignedInteger('kapasitas')->nullable();

            // Status
            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();

            // Index
            $table->index('kode_tahun_ajaran');
            $table->index('kode_kelas');
            $table->index('kode_ruangan');
            $table->index('kode_wali_kelas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_rombel');
    }
};
