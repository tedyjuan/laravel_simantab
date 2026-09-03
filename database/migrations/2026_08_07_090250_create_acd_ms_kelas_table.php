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

            // dari acd_ms_jenjang
            $table->string('kode_jenjang', 10);

            $table->unsignedTinyInteger('tingkat');

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            $table->index([
                'kode_jenjang',
                'tingkat',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_kelas');
    }
};
