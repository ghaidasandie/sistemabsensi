<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);
        Sekolah::create([
            'nama' => 'SMAN 1 CICURUG',
            'alamat' => 'CICURUG SUKABUMI',
            'koordinat' => '-6.798919218710382, 106.77984713684613'
        ]);
        Siswa::create([
            'nisn' => '24012020',
            'nama' => 'Muhammad Rizqi Suhada',
            'jenis_kelamin' => 'l',
            'alamat' => 'Jl.Bubat Babet',
            'koordinat' => '-6.940370163971576, 107.62500684232282'
        ]);
        Siswa::factory()->count(5)->create();
    }
}
