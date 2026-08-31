<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_mapel', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('kode_mapel', 20)->unique();
            $table->string('nama_mapel', 100);
            $table->unsignedTinyInteger('kkm')->default(75); // kriteria ketuntasan minimal

            $table->string('kode_kurikulum')->constrained('acd_ms_kurikulum')->restrictOnDelete();
            $table->string('kode_jenjang')->constrained('acd_ms_jenjang')->restrictOnDelete();
            $table->enum('kelompok', ['wajib', 'peminatan', 'muatan_lokal', 'kebutuhan_khusus', 'keterampilan'])->default('wajib');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_mapel');
    }
};
