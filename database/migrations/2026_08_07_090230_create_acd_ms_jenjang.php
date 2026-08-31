<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_jenjang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jenjang', 10)->unique();
            $table->string('nama_jenjang', 100);
            $table->unsignedTinyInteger('urutan')->default(1);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_jenjang');
    }
};
