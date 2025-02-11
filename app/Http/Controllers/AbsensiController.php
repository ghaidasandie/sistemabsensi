<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $siswas = Siswa::all(); // Data siswa untuk dropdown NISN
    $search = request()->query('search');
    $dateStart = request()->query('date_start');
    $dateEnd = request()->query('date_end');

    // Ambil tanggal absensi yang unik untuk dropdown
    $dates = Absensi::selectRaw('DATE(created_at) as date')
                    ->groupBy('date')
                    ->orderByDesc('date')
                    ->pluck('date');

    if ($search || $dateStart || $dateEnd) {
        $absensis = Absensi::when($search, function ($query) use ($search) {
                $query->whereHas('siswa', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', '%'.$search.'%');
                });
            })
            ->when($dateStart, function ($query) use ($dateStart) {
                $query->whereDate('created_at', '>=', $dateStart);
            })
            ->when($dateEnd, function ($query) use ($dateEnd) {
                $query->whereDate('created_at', '<=', $dateEnd);
            })
            ->paginate(10);
    } else {
        $absensis = Absensi::paginate(10);
    }

    return view('absensi', compact('absensis', 'siswas', 'dates'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        try {
            // Simpan data absensi baru
            Absensi::create($request->all());

            // Redirect dengan pesan sukses
            return redirect('absensi')->with('success', 'Data absensi berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect('absensi')->with('error', 'Terjadi kesalahan saat menambahkan data absensi!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input untuk status
        $validated = $request->validate([
            'status' => 'required|in:a,i,s', // Validasi status yang diizinkan
        ]);

        // Cari absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id);

        // Hanya update status, tidak menyentuh NISN atau Koordinat
        $absensi->status = $validated['status'];
        $absensi->save();

        // Redirect setelah update dengan pesan sukses
        return redirect('/absensi')->with('success', 'Data absensi berhasil diperbarui!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari absensi berdasarkan ID
        $absensi = Absensi::findOrFail($id);

        try {
            // Hapus absensi
            $absensi->delete();

            // Redirect dengan pesan sukses
            return redirect('/absensi')->with('success', 'Data absensi berhasil dihapus!');
        } catch (\Exception $e) {
            // Redirect dengan pesan error
            return redirect('/absensi')->with('error', 'Terjadi kesalahan saat menghapus data absensi!');
        }
    }
}
