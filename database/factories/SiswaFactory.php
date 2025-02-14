<?php
namespace Database\Factories;

use App\Models\Siswa;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;
    private static $usedNames = []; // Array untuk menyimpan nama yang sudah dipakai

    public function definition(): array
    {

        // Daftar nama khas Indonesia (diperbanyak)
        $indonesianNames = [
            'Budi Santoso', 'Siti Aisyah', 'Dewi Lestari', 'Rizky Ramadhan', 'Agus Setiawan',
            'Teguh Prasetyo', 'Hendra Wijaya', 'Indah Permatasari', 'Rina Kartika', 'Eko Susanto',
            'Sri Wahyuni', 'Ahmad Fauzan', 'Lina Marlina', 'Yusuf Alamsyah', 'Dian Purnama',
            'Ari Wibowo', 'Novianti Putri', 'Joko Priyono', 'Heri Kurniawan', 'Desi Ananda',
            'Taufik Hidayat', 'Fitri Handayani', 'Samsul Bahri', 'Nurul Fadilah', 'Rahmat Hidayat',
            'Andi Saputra', 'Mega Wati', 'Fajar Maulana', 'Suci Ramadhani', 'Dedy Setiawan',
            'Irfan Hakim', 'Maya Sari', 'Rizal Fahmi', 'Dewi Sartika', 'Hadi Pranoto'
        ];

        // Daftar alamat unik dengan koordinat
        $addresses = [
            ['alamat' => 'Jl. Merdeka No. 1, Jakarta Pusat', 'koordinat' => '-6.1751, 106.8650'],
            ['alamat' => 'Jl. Taman Sari No. 8, Bandung Timur', 'koordinat' => '-6.9175, 107.6191'],
            ['alamat' => 'Jl. Suryo No. 3, Surabaya Selatan', 'koordinat' => '-7.2504, 112.7688'],
            ['alamat' => 'Jl. Pahlawan No. 15, Yogyakarta Utara', 'koordinat' => '-7.7956, 110.3695'],
            ['alamat' => 'Jl. Angkasa Raya No. 22, Medan Barat', 'koordinat' => '3.5952, 98.6722'],
            ['alamat' => 'Jl. Raya Cendrawasih No. 5, Bali Timur', 'koordinat' => '-8.4095, 115.1889'],
            ['alamat' => 'Jl. Bromo No. 10, Malang Selatan', 'koordinat' => '-8.1125, 112.4316'],
            ['alamat' => 'Jl. Gunung Slamet No. 12, Semarang', 'koordinat' => '-7.0582, 110.4209'],
            ['alamat' => 'Jl. Pantai Indah No. 7, Makassar', 'koordinat' => '-5.1478, 119.4170'],
            ['alamat' => 'Jl. Diponegoro No. 4, Palembang', 'koordinat' => '-2.9761, 104.7754'],
            ['alamat' => 'Jl. Ahmad Yani No. 9, Balikpapan', 'koordinat' => '-1.2429, 116.8946'],
            ['alamat' => 'Jl. Kartini No. 11, Pontianak', 'koordinat' => '-0.0263, 109.3425'],
            ['alamat' => 'Jl. Sultan Hasanuddin No. 6, Makassar', 'koordinat' => '-5.1354, 119.4121'],
            ['alamat' => 'Jl. Rinjani No. 18, Lombok', 'koordinat' => '-8.5833, 116.1167'],
            ['alamat' => 'Jl. Kenari No. 20, Manado', 'koordinat' => '1.4748, 124.8421'],
            ['alamat' => 'Jl. Mangga Dua No. 21, Batam', 'koordinat' => '1.0456, 104.0305'],
            ['alamat' => 'Jl. Danau Toba No. 14, Medan', 'koordinat' => '3.5921, 98.6712'],
            ['alamat' => 'Jl. Hiu Putih No. 19, Banjarmasin', 'koordinat' => '-3.3167, 114.5901'],
            ['alamat' => 'Jl. Laut Selatan No. 8, Kupang', 'koordinat' => '-10.1789, 123.6070'],
            ['alamat' => 'Jl. Nusantara No. 25, Ambon', 'koordinat' => '-3.6954, 128.1827'],
        ];

        // Pilih nama yang belum digunakan
        do {
            $name = $this->faker->randomElement($indonesianNames);
        } while (in_array($name, self::$usedNames) || Siswa::where('nama', $name)->exists());

        // Simpan nama ke daftar nama yang sudah dipakai
        self::$usedNames[] = $name;

        // Tentukan tanggal lahir dengan rentang tahun antara 1999 dan 2009
        $year = $this->faker->numberBetween(1999, 2009);  // Tahun acak antara 1999 dan 2009
        $month = $this->faker->numberBetween(1, 12);  // Bulan acak antara 1 dan 12
        $day = $this->faker->numberBetween(1, 28);  // Hari acak, pastikan tetap valid dalam bulan

        // Pilih alamat secara acak
        $address = $this->faker->randomElement($addresses);

        return [
          'nisn' => fake()->numerify('24012###'),
            'nama' => $name,
            'tanggal_lahir' => "{$year}-{$month}-{$day}",
            'jenis_kelamin' => $this->faker->randomElement(['l', 'p']),
            'alamat' => $address['alamat'],
            'koordinat' => $address['koordinat'],
        ];
    }
}
