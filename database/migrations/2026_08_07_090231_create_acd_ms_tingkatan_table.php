<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_tingkatan', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            // Business key dari master jenjang
            $table->string('kode_tingkatan', 20);  // kode indetifikasi ma jenjang untuk unik
            $table->string('kode_jenjang', 10); // join ke acd_ms_jenjang.kode_jenjang 
            $table->string('nama_tingkatan', 100);
            // Urutan tingkat dalam jenjang
            $table->unsignedTinyInteger('urutan');
            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');
            $table->timestamps();
            $table->unique([
                'kode_jenjang',
                'kode_tingkatan'
            ]);
            $table->index([
                'kode_jenjang',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_tingkatan');
    }
};
