<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fin_ms_jenis_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            $table->string('kode_jenis_pembayaran', 20)->unique();
            $table->string('nama_jenis_pembayaran', 100);

            // Nominal standar/default untuk jenis ini
            $table->decimal('nominal_default', 12, 2)->default(0);

            // Apakah jenis pembayaran bulanan (misal SPP)
            $table->boolean('is_bulanan')->default(false);

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fin_ms_jenis_pembayaran');
    }

    // | kode_jenis_pembayaran | nama_jenis_pembayaran | nominal_default | is_bulanan |
    // | --------------------- | --------------------- | --------------- | ---------- |
    // | SPP                   | SPP Bulanan           |      500000.00  | true       |
    // | SERAGAM               | Seragam Sekolah       |      350000.00  | false      |
    // | BUKU                  | Buku Pelajaran        |      200000.00  | false      |
    // | KEGIATAN              | Biaya Kegiatan        |      150000.00  | false      |
    // | DAFTAR_ULANG          | Daftar Ulang          |     1000000.00  | false      |
};
