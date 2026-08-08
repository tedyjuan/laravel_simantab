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

            // Identitas kelas
            $table->string('kode_kelas', 20)->unique();
            $table->string('nama_kelas', 50);
            $table->unsignedTinyInteger('tingkat'); // contoh: 1,2,3 (SD/SMP/SMA) atau 10,11,12
            $table->string('jurusan', 50)->nullable(); // IPA, IPS, dll (opsional)
            $table->string('rombel', 5)->nullable(); // rombongan belajar, misal A, B, C

            // Relasi
            $table->foreignId('id_tahun_ajaran')
                ->constrained('acd_ms_tahun_ajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('id_wali_kelas')
                ->nullable()
                ->constrained('hr_ms_pegawai')
                ->nullOnDelete();

            // Info tambahan
            $table->unsignedSmallInteger('kapasitas')->default(30);
            $table->string('ruangan', 50)->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index(['tingkat', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_kelas');
    }
};
