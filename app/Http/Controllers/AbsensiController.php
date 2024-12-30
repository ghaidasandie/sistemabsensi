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
        // Ambil data absensi dan siswa dari database
        $absensis = Absensi::all(); // Data absensi
        $siswas = Siswa::all(); // Data siswa untuk dropdown NISN

        // Kirim data ke view
        return view('absensi', compact('absensis', 'siswas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nisn' => 'required|numeric|exists:siswas,nisn', // Pastikan NISN ada di tabel siswa
            'status' => 'required|in:i,s,a', // Status harus izin (i), sakit (s), atau alfa (a)
            'koordinat' => 'required|string',
        ]);

        try {
            // Simpan data absensi baru
            Absensi::create($validated);

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
        'status' => 'required|in:h,i,s', // Validasi status yang diizinkan
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
