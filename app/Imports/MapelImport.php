<?php

namespace App\Imports;

use App\Models\Mapel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MapelImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Model|array|null
    {
        return new Mapel([
            'ulid'           => (string) Str::ulid(),
            'kode_mapel'     => $row['kode_mapel'],
            'nama_mapel'     => $row['nama_mapel'],
            'kkm'            => $row['kkm'],
            'kode_kurikulum' => $row['kode_kurikulum'], // kurikulum is here (KURMER-2026-2027)
            'kode_jenjang'   => $row['kode_jenjang'], // jenjang is here
            'kelompok'       => $row['kelompok'],
            'status'         => $row['status'],
        ]);
    }
}
