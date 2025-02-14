<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat User Admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
        ]);

        // Buat Data Siswa
        Siswa::create([
            'nisn' => '24012020',
            'nama' => 'Muhammad Rizqi Suhada',
            'tanggal_lahir' => '1999-08-15',
            'jenis_kelamin' => 'l',
            'alamat' => 'Jl.Bubat Babet',
            'koordinat' => '-6.7965517,106.7580333'
        ]);

        // Buat 9 Siswa lainnya
        Siswa::factory()->count(9)->create();

        // Buat Status Absensi
        Status::create([
            'status' => 'offline',
            'mulai' => null,
            'selesai' => null,
        ]);

        // Buat Absensi untuk Rizqi Suhada (12 hadir, 1 izin, 1 sakit)
        $siswaRizqi = Siswa::where('nisn', '24012020')->first();

        // Menambahkan absensi hadir (12 kali) dengan koordinat dan timestamp
        for ($i = 0; $i < 12; $i++) {
            Absensi::create([
                'nisn' => $siswaRizqi->nisn,
                'status' => 'h',  // h = Hadir
                'koordinat' => $siswaRizqi->koordinat,  // Menambahkan koordinat
                'created_at' => Carbon::now()->subDays($i),  // Menambahkan timestamp untuk tanggal absensi
                'updated_at' => Carbon::now()->subDays($i),  // Timestamp update
            ]);
        }

        // Menambahkan absensi izin (1 kali) dengan koordinat dan timestamp
        Absensi::create([
            'nisn' => $siswaRizqi->nisn,
            'status' => 'i',  // i = Izin
            'koordinat' => $siswaRizqi->koordinat,  // Menambahkan koordinat
            'created_at' => Carbon::now()->subDays(9),  // 1 hari sebelumnya
            'updated_at' => Carbon::now()->subDays(9),  // Timestamp update
        ]);

        // Menambahkan absensi sakit (1 kali) dengan koordinat dan timestamp
        Absensi::create([
            'nisn' => $siswaRizqi->nisn,
            'status' => 's',  // s = Sakit
            'koordinat' => $siswaRizqi->koordinat,  // Menambahkan koordinat
            'created_at' => Carbon::now()->subDays(10),  // 2 hari sebelumnya
            'updated_at' => Carbon::now()->subDays(10),  // Timestamp update
        ]);

        // Buat Absensi dengan tanggal dan status acak untuk 9 Siswa Lainnya
        $siswas = Siswa::where('nisn', '!=', '24012020')->get();

        foreach ($siswas as $siswa) {
            // Buat 10 absensi acak untuk siswa lainnya
            for ($i = 0; $i < 14; $i++) {
                $status = $this->randomAbsensiStatus();  // Ambil status acak
                Absensi::create([
                    'nisn' => $siswa->nisn,
                    'status' => $status,  // Status acak
                    'koordinat' => $siswa->koordinat,  // Menambahkan koordinat
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),  // Tanggal acak antara 1 sampai 30 hari lalu
                    'updated_at' => Carbon::now()->subDays(rand(1, 30)),  // Timestamp update acak
                ]);
            }
        }
    }

    /**
     * Menghasilkan status absensi acak
     *
     * @return string
     */
    private function randomAbsensiStatus(): string
    {
        // Ambil status absensi acak
        $statuses = ['h', 'i', 's', 'a'];  // h = Hadir, i = Izin, s = Sakit, a = Absen
        return $statuses[array_rand($statuses)];
    }
}
