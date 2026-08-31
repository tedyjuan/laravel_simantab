<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_kelas', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('kode_kelas', 20)->unique();
            $table->string('nama_kelas', 50);

            // Tingkatan
            $table->foreignId('id_tingkatan')
                ->constrained('acd_ms_tingkatan')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Rombel
            $table->string('kode_rombel', 10);
            $table->string('nama_rombel', 50)->nullable();

            // Tahun Ajaran
            $table->foreignId('id_tahun_ajaran')
                ->constrained('acd_ms_tahun_ajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Wali Kelas
            $table->foreignId('id_wali_kelas')
                ->nullable()
                ->constrained('hr_ms_pegawai')
                ->nullOnDelete();

            // Kapasitas
            $table->unsignedSmallInteger('kapasitas')->default(30);

            // Ruangan
            $table->string('ruangan', 50)->nullable();

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'id_tingkatan',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_kelas');
    }
};
