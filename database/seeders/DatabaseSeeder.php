<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Budi Santoso',
            'username' => 'guru',
            'email' => 'guru01@sekolah.test',
            'password' => '123',
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Andi Saputra',
            'username' => 'siswa01',
            'email' => 'siswa01@sekolah.test',
            'password' => 'password',
            'role' => 'siswa',
        ]);

        User::create([
            'name' => 'Siti Aminah',
            'username' => 'wali01',
            'email' => 'wali01@sekolah.test',
            'password' => 'password',
            'role' => 'walimurid',
        ]);
    }
}
