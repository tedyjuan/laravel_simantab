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
                'kode_kurikulum' => 'KKM001',
                'nama_kurikulum' => 'Kurikulum 2013',
                'deskripsi' => 'Kurikulum 2013 (K13)',
                'status' => 'nonaktif',
            ],
            [
                'ulid' => (string) Str::ulid(),
                'kode_kurikulum' => 'KKM002',
                'nama_kurikulum' => 'Kurikulum Merdeka',
                'deskripsi' => 'Kurikulum Merdeka',
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
