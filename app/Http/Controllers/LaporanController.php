<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // Menampilkan laporan absensi dengan filter tanggal
    public function index(Request $request)
    {
        $dateStart = $request->get('date_start', now()->startOfMonth()->toDateString());
        $dateEnd = $request->get('date_end', now()->toDateString());

        // Mengambil data absensi dengan pagination
        $absensis = Absensi::whereBetween('created_at', [$dateStart, $dateEnd])
                    ->with('siswa')
                    ->orderBy('created_at', 'asc')
                    ->paginate(10)
                    ->appends([
                        'date_start' => $dateStart,
                        'date_end' => $dateEnd
                    ]);

        return view('laporan', [
            'absensis' => $absensis,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd
        ]);
    }

    // Mengunduh laporan absensi dalam format PDF
    public function export(Request $request)
    {
        $dateStart = $request->get('date_start', now()->startOfMonth()->toDateString());
        $dateEnd = $request->get('date_end', now()->toDateString());

        // Ambil data absensi dalam rentang tanggal
        $absensis = Absensi::whereBetween('created_at', [$dateStart, $dateEnd])
                            ->with('siswa')
                            ->orderBy('created_at', 'asc')
                            ->get();

        // Buat PDF dengan data absensi menggunakan view laporan_pdf
        $pdf = Pdf::loadView('laporan_pdf', [
            'absensis' => $absensis,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd
        ]);

        // Kembalikan file PDF untuk diunduh
        return $pdf->download('laporan_absensi.pdf');
    }

}
