<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_ms_pegawai', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            // Business key pegawai
            $table->string('kode_pegawai', 30)->nullable()->unique();
            // NIP bersifat opsional
            $table->string('nip', 30)->nullable()->unique();

            // Identitas
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->string('email', 100)->nullable()->unique();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();

            // Relasi ke master jabatan menggunakan kode
            $table->string('kode_jabatan', 20)->nullable();

            $table->date('tanggal_masuk')->nullable();

            // Status pegawai
            $table->enum('status', [
                'aktif',
                'nonaktif',
                'cuti'
            ])->default('aktif');

            $table->timestamps();
            $table->softDeletes();

            $table->index('kode_pegawai');
            $table->index('kode_jabatan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_ms_pegawai');
    }
};
