<?php

namespace Database\Seeders;

use App\Models\TahunAjar;
use Illuminate\Database\Seeder;

class TahunAjarSeeder extends Seeder
{
    public function run(): void
    {
        TahunAjar::factory()->count(20)->create();
    }
}
