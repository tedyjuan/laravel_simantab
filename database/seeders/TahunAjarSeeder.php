<?php

namespace Database\Seeders;

use App\Models\TahunAjar;
use Illuminate\Database\Seeder;

class TahunAjarSeeder extends Seeder
{
    public function run(): void
    {
        $tahunMulai = 2025;

        TahunAjar::factory()
            ->count(8)
            ->create()
            ->each(function ($tahunAjar, $index) use ($tahunMulai) {

                // 1 tahun ajaran = 2 semester
                $tahunAwal  = $tahunMulai + intdiv($index, 2);
                $tahunAkhir = $tahunAwal + 1;
                $semesterGanjil = $index % 2 === 0;

                if ($semesterGanjil) {
                    $semester       = 'Ganjil';
                    $tanggalMulai   = "{$tahunAwal}-07-01";
                    $tanggalSelesai = "{$tahunAwal}-12-31";
                } else {
                    $semester       = 'Genap';
                    $tanggalMulai   = "{$tahunAkhir}-01-01";
                    $tanggalSelesai = "{$tahunAkhir}-06-30";
                }

                $kode = 'TAS' . str_pad($tahunAjar->id, 3, '0', STR_PAD_LEFT);
                $tahunAjar->update([
                    'kode_tahun_ajaran' => $kode,
                    'nama'              => "Tahun Ajaran {$tahunAwal}/{$tahunAkhir}",
                    'semester'          => $semester,
                    'tanggal_mulai'     => $tanggalMulai,
                    'tanggal_selesai'   => $tanggalSelesai,
                    'status'            => 'nonaktif',
                ]);
            });
    }
}
