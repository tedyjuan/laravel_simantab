<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fin_trx_tagihan', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            $table->string('kode_tagihan', 30)->unique();

            // Siswa yang ditagih
            $table->string('nis', 30);

            // Jenis pembayaran
            $table->string('kode_jenis_pembayaran', 20);

            // Tahun Ajaran
            $table->string('kode_tahun_ajaran', 20);

            // Bulan (untuk pembayaran bulanan seperti SPP, 1-12)
            $table->unsignedTinyInteger('bulan')->nullable();

            // Nominal tagihan
            $table->decimal('nominal', 12, 2);

            $table->enum('status', [
                'belum_bayar',
                'lunas',
                'sebagian'
            ])->default('belum_bayar');

            $table->date('tanggal_jatuh_tempo')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('nis')
                ->references('nis')
                ->on('std_ms_siswa')
                ->restrictOnDelete();

            $table->foreign('kode_jenis_pembayaran')
                ->references('kode_jenis_pembayaran')
                ->on('fin_ms_jenis_pembayaran')
                ->restrictOnDelete();

            $table->foreign('kode_tahun_ajaran')
                ->references('kode_tahun_ajaran')
                ->on('acd_ms_tahun_ajaran')
                ->restrictOnDelete();

            $table->index(['nis', 'kode_tahun_ajaran', 'status']);
            $table->index(['kode_jenis_pembayaran', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fin_trx_tagihan');
    }
};
