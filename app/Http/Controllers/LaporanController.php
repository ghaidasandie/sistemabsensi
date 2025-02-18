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
        // Mendapatkan tanggal mulai dan tanggal akhir dari request, dengan fallback default
        $dateStart = $request->get('date_start', now()->startOfMonth()->toDateString());
        $dateEnd = $request->get('date_end', now()->toDateString());

        // Tambahkan waktu akhir pada tanggal akhir untuk memastikan data sampai akhir hari
        $dateEnd = Carbon::parse($dateEnd)->endOfDay();

        // Ambil data absensi dalam rentang tanggal
        $absensis = Absensi::whereBetween('created_at', [$dateStart, $dateEnd])
            ->with('siswa')
            ->orderBy('created_at', 'asc')
            ->get();

        // Buat PDF dengan data absensi menggunakan view laporan_pdf
        $pdf = Pdf::loadView('laporan_pdf', [
            'absensis' => $absensis,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd->toDateString() // Pastikan format tanggal yang dikirim ke view adalah format yang sesuai
        ]);

        // Kembalikan file PDF untuk diunduh
        return $pdf->download('laporan_absensi.pdf');
    }
}
