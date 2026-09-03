<?php

namespace Database\Seeders;

use App\Models\Kurikulum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KurikulumSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'ulid' => (string) Str::ulid(),
                'kode_kurikulum' => 'K13',
                'nama_kurikulum' => 'Kurikulum 2013',
                'deskripsi' => 'Kurikulum 2013 (K13)',
                'status' => 'nonaktif',
            ],
            [
                'ulid' => (string) Str::ulid(),
                'kode_kurikulum' => 'KURMER-2025-2026',
                'nama_kurikulum' => 'Kurikulum Merdeka',
                'deskripsi' => 'Kurikulum Merdeka tahun ajaran 2025/2026',
                'status' => 'nonaktif',
            ],
            [
                'ulid' => (string) Str::ulid(),
                'kode_kurikulum' => 'KURMER-2026-2027',
                'nama_kurikulum' => 'Kurikulum Merdeka',
                'deskripsi' => 'Kurikulum Merdeka tahun ajaran 2026/2027',
                'status' => 'aktif',
            ],
        ];

        foreach ($data as $row) {
            Kurikulum::updateOrCreate(
                ['kode_kurikulum' => $row['kode_kurikulum']], // biar aman kalau seeder dijalankan berkali-kali
                $row
            );
        }
    }
}
