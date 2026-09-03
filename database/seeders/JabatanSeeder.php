<?php

namespace Database\Seeders;

use App\Imports\JabatanImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;


class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        Excel::import(
            new JabatanImport,
            database_path('seeders/data/data_jabatan.xlsx')
        );
    }
}
