<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan tanggal mulai dan tanggal akhir dari request, dengan fallback default
        $dateStart = $request->get('date_start', now()->startOfMonth()->toDateString());
        $dateEnd = $request->get('date_end', now()->toDateString());

        // Tambahkan waktu akhir pada tanggal akhir untuk memastikan data sampai akhir hari
        $dateEnd = Carbon::parse($dateEnd)->endOfDay();

        // Mengambil data absensi dengan pagination
        $absensis = Absensi::whereBetween('created_at', [$dateStart, $dateEnd])
            ->with('siswa')
            ->orderBy('created_at', 'asc')
            ->paginate(10)
            ->appends([
                'date_start' => $dateStart,
                'date_end' => $dateEnd->toDateString()
            ]);

        return view('laporan', [
            'absensis' => $absensis,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd->toDateString() // Pastikan format tanggal yang dikirim ke view adalah format yang sesuai
        ]);
    }

    public function export(Request $request)
    {
        $dateStart = $request->get('date_start', now()->startOfMonth()->toDateString());
        $dateEnd = \Carbon\Carbon::parse($request->get('date_end', now()->toDateString()))->endOfDay();

        // Ambil data absensi dalam rentang tanggal
        $absensis = Absensi::whereBetween('created_at', [$dateStart, $dateEnd])
            ->with('siswa')
            ->orderBy('created_at', 'asc')
            ->get();

        // Hitung jumlah status absensi per siswa
        $siswaAbsensi = $absensis->groupBy('nisn')->map(function ($group) {
            $siswa = $group->first()->siswa;
            return [
                'nisn' => $siswa->nisn,
                'nama' => $siswa->nama,
                'hadir' => $group->where('status', 'h')->count(),
                'izin' => $group->where('status', 'i')->count(),
                'sakit' => $group->where('status', 's')->count(),
            ];
        });

        // Hitung siswa yang paling sering hadir
        $siswaHadirTerbanyak = $siswaAbsensi->sortByDesc('hadir')->first();

        // Generate Pie Chart dengan label di dalamnya
        $chartUrl = "https://quickchart.io/chart?c=" . urlencode(json_encode([
            'type' => 'pie',
            'data' => [
                'labels' => ['Hadir', 'Izin', 'Sakit'],
                'datasets' => [[
                    'data' => [
                        $siswaAbsensi->sum('hadir'),
                        $siswaAbsensi->sum('izin'),
                        $siswaAbsensi->sum('sakit'),
                    ],
                    'backgroundColor' => ['#28a745', '#ffc107', '#dc3545']
                ]]
            ],
            'options' => [
                'plugins' => [
                    'datalabels' => [
                        'display' => true,
                        'color' => '#fff',  // Warna teks
                        'font' => [
                            'weight' => 'bold',
                            'size' => 14,  // Ukuran font yang lebih besar
                        ],
                        'formatter' => function($value, $context) {
                            return $value;  // Menampilkan nilai di dalam chart
                        }
                    ]
                ],
                'responsive' => true,
                'maintainAspectRatio' => false
            ]
        ]));

        // Konversi chart ke base64
        $chartImage = base64_encode(file_get_contents($chartUrl));

        // Buat PDF
        $pdf = Pdf::loadView('laporan_pdf', [
            'siswaAbsensi' => $siswaAbsensi, // Kirim data siswaAbsensi
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd->toDateString(),
            'chartImage' => $chartImage,
            'siswaHadirTerbanyak' => $siswaHadirTerbanyak
        ]);

        return $pdf->download('laporan_absensi.pdf');
    }

}
