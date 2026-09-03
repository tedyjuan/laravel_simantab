<?php

namespace Database\Factories;

use App\Models\TahunAjar;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TahunAjarFactory extends Factory
{
    protected $model = TahunAjar::class;
    public function definition(): array
    {
        $ta = $this->faker->unique()->numerify('TA####');

        return [
            'ulid'              => (string) Str::ulid(),
            'kode_tahun_ajaran' => $ta,
            'nama'              => 'Tahun Ajaran ' . $ta,
            'tanggal_mulai'     => fake()->date(),
            'tanggal_selesai'   => fake()->date(),
            'semester'          => fake()->randomElement(['Ganjil', 'Genap']),
            'status'            => fake()->randomElement(['aktif', 'nonaktif']),
        ];
    }
}
