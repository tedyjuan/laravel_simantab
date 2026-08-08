<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_ms_kurikulum', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 100); // contoh: Kurikulum Merdeka
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_ms_kurikulum');
    }
};
