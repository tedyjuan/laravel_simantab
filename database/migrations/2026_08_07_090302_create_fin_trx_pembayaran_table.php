<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fin_trx_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            $table->string('kode_pembayaran', 30)->unique();

            // Tagihan yang dibayar
            $table->string('kode_tagihan', 30);

            // Nominal yang dibayarkan
            $table->decimal('nominal_bayar', 12, 2);

            $table->enum('metode_bayar', [
                'tunai',
                'transfer',
                'qris'
            ])->default('tunai');

            $table->date('tanggal_bayar');

            $table->text('keterangan')->nullable();

            // Penerima pembayaran (pegawai)
            $table->string('kode_pegawai', 30)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('kode_tagihan')
                ->references('kode_tagihan')
                ->on('fin_trx_tagihan')
                ->restrictOnDelete();

            $table->foreign('kode_pegawai')
                ->references('kode_pegawai')
                ->on('hr_ms_pegawai')
                ->nullOnDelete();

            $table->index('kode_tagihan');
            $table->index('tanggal_bayar');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fin_trx_pembayaran');
    }
};
