<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Jabatan;

class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;
    public function definition(): array
    {
        $faker = fake('id_ID');
        $jabatan = Jabatan::where('status', 'aktif')
            ->inRandomOrder()
            ->first();
        return [
            'ulid'          => (string) Str::ulid(),
            'kode_pegawai'  => 'PGW-' . fake()->unique()->numerify('#####'),
            'nip'           => fake()->unique()->numerify('#################'),
            'nama'          => $faker->name(),
            'jenis_kelamin' => $faker->randomElement(['L', 'P',]),
            'email'         => $faker->unique()->safeEmail(),
            'no_hp'         => $faker->phoneNumber(),
            'alamat'        => $faker->address(),
            'tanggal_lahir' => $faker->dateTimeBetween('-60 years', '-23 years')->format('Y-m-d'),
            'kode_jabatan'  => $jabatan?->kode_jabatan,
            'tanggal_masuk' => $faker->dateTimeBetween('-15 years', 'now')->format('Y-m-d'),
            'status'        => 'aktif',
        ];
    }
}
