<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_ms_jabatan', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            // Business key
            $table->string('kode_jabatan', 20)->unique();

            // Nama jabatan
            $table->string('nama_jabatan', 100);

            // Optional: kelompok jabatan
            $table->enum('jenis_jabatan', [
                'struktural',
                'fungsional',
                'pelaksana'
            ])->default('pelaksana');

            // Urutan tampilan
            $table->unsignedSmallInteger('urutan')->default(1);

            $table->enum('status', [
                'aktif',
                'nonaktif'
            ])->default('aktif');

            $table->timestamps();

            $table->index([
                'jenis_jabatan',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_ms_jabatan');
    }


    // | kode_jabatan | nama_jabatan         | jenis      |
    // | ------------ | -------------------- | ---------- |
    // | KEPSEK       | Kepala Sekolah       | struktural |
    // | WAKASEK      | Wakil Kepala Sekolah | struktural |
    // | GURU         | Guru                 | fungsional |
    // | TU           | Tata Usaha           | pelaksana  |
    // | ADMIN        | Administrator        | pelaksana  |
    // | BENDAHARA    | Bendahara            | pelaksana  |
    // | PUSTAKAWAN   | Pustakawan           | pelaksana  |

};
