<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('std_ms_siswa', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->string('nis', 30)->unique();
            $table->string('nisn', 20)->unique()->nullable();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp', 20)->nullable();

            $table->foreignId('id_kelas')
                ->nullable()
                ->constrained('acd_ms_kelas')
                ->nullOnDelete();

            $table->string('nama_wali', 100)->nullable();
            $table->string('no_hp_wali', 20)->nullable();

            $table->date('tanggal_masuk')->nullable();
            $table->enum('status', ['aktif', 'lulus', 'pindah', 'keluar'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['id_kelas', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('std_ms_siswa');
    }
};
