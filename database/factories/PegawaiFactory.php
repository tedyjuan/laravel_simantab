<?php

namespace Database\Factories;

use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;
    public function definition(): array
    {
        return [
            'nip'           => fake()->unique()->numerify('##########'),
            'nama'          => fake()->name(),
            'jenis_kelamin' => fake()->randomElement(['L', 'P']),
            'email'         => fake()->unique()->safeEmail(),
            'no_hp'         => fake()->phoneNumber(),
            'alamat'        => fake()->address(),
            'tanggal_lahir' => fake()->dateTimeBetween('-60 years', '-22 years')->format('Y-m-d'),
            'jenis_pegawai' => fake()->randomElement(['guru', 'staff', 'kepala_sekolah',]),
            'jabatan'       => fake()->randomElement(['Guru', 'Wali Kelas', 'Kepala Sekolah', 'Wakil Kepala Sekolah', 'Staff Tata Usaha', 'Bendahara', 'Operator', 'Administrasi',]),
            'tanggal_masuk' => fake()->dateTimeBetween('-15 years', 'now')->format('Y-m-d'),
            'status'        => fake()->randomElement(['aktif', 'nonaktif', 'cuti',]),
        ];
    }
}
