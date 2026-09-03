<?php

namespace Database\Seeders;

use App\Imports\MapelImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        Excel::import(
            new MapelImport,
            database_path('seeders/data/data_mapel.xlsx')
        );
    }
}
