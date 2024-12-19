<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{

    public function update(Request $request, $id)
    {
        // Validasi data
        $validated = $request->validate([
            'nisn' => 'required|numeric',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:l,p',
            'alamat' => 'required|string',
            'koordinat' => 'required|string',
        ]);

        // Cari siswa berdasarkan ID
        $siswa = Siswa::findOrFail($id);

        // Perbarui data siswa
        $siswa->update($validated);

        // Redirect kembali ke halaman admin dengan pesan sukses
        return redirect('/admin')->with('success', 'Data siswa berhasil diperbarui');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|numeric|unique:siswas,nisn',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:l,p',
            'alamat' => 'required|string',
            'koordinat' => 'required|string',
        ]);

        try {
            // Save new student data
            Siswa::create($validated);

            // Redirect back with success message
            return redirect('admin')->with('success', 'Data siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Handle errors and show a custom error message
            return redirect('admin')->with('error', 'Terjadi kesalahan saat menambahkan data siswa!');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.


     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Cari siswa berdasarkan ID
        $siswa = Siswa::findOrFail($id);

        // Hapus siswa
        $siswa->delete();

        // Redirect dengan pesan sukses
        return redirect('/admin')->with('success', 'Data siswa berhasil dihapus!');
    }

}
