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

            $table->string('kode_kelas', 20)->nullable()->unique();
            $table->string('nama_kelas', 50);

            // Relasi ke acd_ms_jenjang
            $table->string('kode_jenjang', 10);


            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('kode_jenjang')
                ->references('kode_jenjang')
                ->on('acd_ms_jenjang')
                ->restrictOnDelete();

            $table->index([
                'kode_jenjang',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_kelas');
    }
};
