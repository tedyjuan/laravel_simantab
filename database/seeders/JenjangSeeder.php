<?php

namespace Database\Seeders;

use App\Imports\JenjangImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;


class JenjangSeeder extends Seeder
{
    public function run(): void
    {
        Excel::import(
            new JenjangImport,
            database_path('seeders/data/data_jenjang.xlsx')
        );
    }
}
