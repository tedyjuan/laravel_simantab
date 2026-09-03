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
            $table->string('kode_mapel', 20)->nullable()->unique();
            $table->string('nama_mapel', 100);
            $table->unsignedTinyInteger('kkm')->default(75); // kriteria ketuntasan minimal

            // Relasi ke kurikulum
            $table->string('kode_kurikulum', 20);

            // Relasi ke jenjang
            $table->string('kode_jenjang', 10);

            $table->enum('kelompok', [
                'wajib',
                'peminatan',
                'muatan_lokal',
                'kebutuhan_khusus',
                'keterampilan'
            ])->default('wajib');

            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('kode_kurikulum')
                ->references('kode_kurikulum')
                ->on('acd_ms_kurikulum')
                ->restrictOnDelete();

            $table->foreign('kode_jenjang')
                ->references('kode_jenjang')
                ->on('acd_ms_jenjang')
                ->restrictOnDelete();

            $table->index(['kode_kurikulum', 'kode_jenjang', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_mapel');
    }
};
