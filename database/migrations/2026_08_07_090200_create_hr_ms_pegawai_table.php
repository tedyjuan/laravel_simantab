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
            $table->string('nip', 30)->unique()->nullable(); // Nomor Induk Pegawai
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('email', 100)->unique()->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->enum('jenis_pegawai', ['guru', 'staff', 'kepala_sekolah'])->default('guru');
            $table->string('jabatan', 50)->nullable();
            $table->date('tanggal_masuk')->nullable();

            $table->enum('status', ['aktif', 'nonaktif', 'cuti'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['jenis_pegawai', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_ms_pegawai');
    }
};
