<?php

namespace App\Imports;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JabatanImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Model|array|null
    {
        return new Jabatan([
            'ulid'           => (string) Str::ulid(),
            'kode_jabatan' => $row['kode_jabatan'],
            'nama_jabatan' => $row['nama_jabatan'],
            'urutan'       => $row['urutan'],
            'status'       => $row['status'],
        ]);
    }
}
