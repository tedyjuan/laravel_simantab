<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inv_ms_gedung', function (Blueprint $table) {
            $table->id();

            $table->ulid('ulid')->unique();
            // Contoh: GDG-A, GDG-UTAMA
            $table->string('kode_gedung', 20)->unique();
            // Contoh: Gedung Utama
            $table->string('nama_gedung', 100);
            // Alamat/lokasi gedung jika diperlukan
            $table->text('alamat')->nullable();
            // Jumlah lantai
            $table->unsignedTinyInteger('jumlah_lantai')->default(1);
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
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inv_ms_gedung');
    }
};
