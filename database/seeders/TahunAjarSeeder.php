<?php

namespace Database\Seeders;

use App\Models\TahunAjar;
use App\Models\TahunAjarDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TahunAjarSeeder extends Seeder
{
    public function run(): void
    {
        $tahunMulai = 2025;

        for ($i = 0; $i < 4; $i++) {

            $tahunAwal  = $tahunMulai + $i;
            $tahunAkhir = $tahunAwal + 1;
            // Tahun ajaran terakhir = aktif
            $set_status = ($i === 3) ? 'aktif' : 'nonaktif';
            // =========================
            // HEADER
            // =========================

            $kodeHeader = 'TAH' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);

            $header = TahunAjar::updateOrCreate(
                [
                    'kode_tahun_ajaran_header' => $kodeHeader,
                ],
                [
                    'ulid'                     => (string) Str::ulid(),
                    'nama_tahun_ajaran_header' => "Tahun Ajaran {$tahunAwal}/{$tahunAkhir}",
                    'tahun_mulai'              => $tahunAwal,
                    'tahun_selesai'            => $tahunAkhir,
                    'status'                   => $set_status,
                ]
            );

            // =========================
            // SEMESTER GANJIL
            // =========================

            $this->createDetail(
                header: $header,
                kode: 'TAD' . str_pad(($i * 2) + 1, 3, '0', STR_PAD_LEFT),
                semester: 'ganjil',
                tanggalMulai: "{$tahunAwal}-07-01",
                tanggalSelesai: "{$tahunAwal}-12-31",
            );

            // =========================
            // SEMESTER GENAP
            // =========================

            $this->createDetail(
                header: $header,
                kode: 'TAD' . str_pad(($i * 2) + 2, 3, '0', STR_PAD_LEFT),
                semester: 'genap',
                tanggalMulai: "{$tahunAkhir}-01-01",
                tanggalSelesai: "{$tahunAkhir}-06-30",
            );
        }
    }

    private function createDetail(
        TahunAjar $header,
        string $kode,
        string $semester,
        string $tanggalMulai,
        string $tanggalSelesai,
    ): void {
        TahunAjarDetail::updateOrCreate(
            [
                'kode_tahun_ajaran_detail' => $kode,
            ],
            [
                'ulid'                     => (string) Str::ulid(),
                'kode_tahun_ajaran_header' => $header->kode_tahun_ajaran_header,
                'nama_tahun_ajaran_detail' => $header->nama_tahun_ajaran_header,
                'semester'                 => $semester,
                'tanggal_mulai'            => $tanggalMulai,
                'tanggal_selesai'          => $tanggalSelesai,
            ]
        );
    }
}
