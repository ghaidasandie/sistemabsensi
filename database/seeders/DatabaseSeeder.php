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

        // Ambil data siswa
        $siswaRizqi = Siswa::where('nisn', '24012020')->first();
        $siswas = Siswa::where('nisn', '!=', '24012020')->get();

        // Tanggal awal untuk absensi 30 hari terakhir
        $startDate = Carbon::now()->subDays(30);

        // Absensi untuk Rizqi Suhada (12 hari berturut-turut hadir, lalu izin & sakit realistis)
        for ($i = 0; $i < 14; $i++) {
            $tanggal = $startDate->copy()->addDays($i); // Tanggal urut
            $status = $i < 10 ? 'h' : ($i == 10 ? 'i' : 's'); // 10 hari hadir, lalu izin, lalu sakit

            Absensi::create([
                'nisn' => $siswaRizqi->nisn,
                'status' => $status,
                'koordinat' => $siswaRizqi->koordinat,
                'created_at' => $tanggal,
                'updated_at' => $tanggal,
            ]);
        }

        // Buat Absensi untuk Siswa Lainnya dengan tanggal yang terurut
        foreach ($siswas as $siswa) {
            $tanggalMulai = $startDate->copy();

            for ($i = 0; $i < 14; $i++) {
                $tanggal = $tanggalMulai->copy()->addDays($i); // Pastikan tanggalnya urut
                $status = $this->randomAbsensiStatus();

                Absensi::create([
                    'nisn' => $siswa->nisn,
                    'status' => $status,
                    'koordinat' => $siswa->koordinat,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
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
        $statuses = ['h', 'i', 's', 'a'];  // Hadir, Izin, Sakit, Absen
        return $statuses[array_rand($statuses)];
    }
}
