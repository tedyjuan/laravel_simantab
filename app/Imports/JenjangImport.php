<?php

namespace App\Imports;

use App\Models\Jenjang;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JenjangImport implements ToModel, WithHeadingRow
{
    public function model(array $row): Model|array|null
    {
        // dd($row);
        return new Jenjang([
            'kode_jenjang' => $row['kode_jenjang'],
            'nama_jenjang' => $row['nama_jenjang'],
            'urutan'       => $row['urutan'],
            'status'       => $row['status'],
        ]);
    }
}
