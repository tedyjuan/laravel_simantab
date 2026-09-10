<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Jenjang;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KelasFactory extends Factory
{
    protected $model = Kelas::class;

    public function definition(): array
    {
        $jenjang = Jenjang::where('status', 'aktif')
            ->inRandomOrder()
            ->first();

        return [
            'ulid'          => (string) Str::ulid(),
            'kode_kelas'    => 'KLS-' . fake()->unique()->numerify('#####'),
            'nama_kelas'    => 'Kelas ' . fake()->numberBetween(1, 12),
            'kode_jenjang'  => $jenjang?->kode_jenjang,
            'status'        => 'aktif',
        ];
    }
}
