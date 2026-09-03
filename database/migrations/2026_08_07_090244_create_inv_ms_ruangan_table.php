<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inv_ms_ruangan', function (Blueprint $table) {
            $table->id();

            $table->ulid('ulid')->unique();

            // Contoh: R-A101
            $table->string('kode_ruangan', 20)->unique();

            // Contoh: Ruang Kelas 1A
            $table->string('nama_ruangan', 100);

            // Relasi ke master gedung
            $table->string('kode_gedung', 20);

            // Contoh: 1, 2, 3
            $table->unsignedTinyInteger('lantai')->default(1);

            // Kapasitas maksimal ruangan
            $table->unsignedSmallInteger('kapasitas')->nullable();

            // Jenis penggunaan ruangan
            $table->enum('jenis', [
                'kelas',
                'laboratorium',
                'perpustakaan',
                'kantor',
                'aula',
                'ruang_guru',
                'uks',
                'gudang',
                'lainnya'
            ])->default('kelas');

            // Keterangan tambahan
            $table->text('deskripsi')->nullable();

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'kode_gedung',
                'jenis',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inv_ms_ruangan');
    }
};
