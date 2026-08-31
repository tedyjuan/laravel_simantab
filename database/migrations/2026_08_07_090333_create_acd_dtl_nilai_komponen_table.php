<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acd_dtl_nilai_komponen', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->foreignId('id_nilai')
                ->constrained('acd_trx_nilai')
                ->cascadeOnDelete();

            $table->enum('jenis_komponen', [
                'tugas',
                'uts',
                'uas',
                'kuis',
                'praktik',
                'sikap'
            ]);

            $table->string('nama_komponen', 100)->nullable(); // contoh: "Tugas Bab 1"
            $table->decimal('nilai', 5, 2);
            $table->decimal('bobot', 5, 2)->default(0); // persen bobot ke nilai akhir
            $table->date('tanggal_input')->nullable();

            $table->timestamps();

            $table->index(['id_nilai', 'jenis_komponen']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acd_dtl_nilai_komponen');
    }
};
