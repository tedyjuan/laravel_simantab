<?php

namespace Database\Factories;

use App\Models\TahunAjarDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class TahunAjarDetailFactory extends Factory
{
    protected $model = TahunAjarDetail::class;

    public function definition(): array
    {
        return [
            'kode_tahun_ajaran_detail' => null,
            'kode_tahun_ajaran_header' => null,
            'nama_tahun_ajaran_detail' => null,
            'semester' => null,
            'tanggal_mulai' => null,
            'tanggal_selesai' => null,
            'status' => 'nonaktif',

        ];
    }
}
