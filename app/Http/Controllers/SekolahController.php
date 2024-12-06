<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sekolah=Sekolah::all();
        return $sekolah;
    }

    
    public function store(Request $request)
    {
        $nama = $request->nama;
        $alamat = $request->alamat;
        $koordinat = $request->koordinat;
        Sekolah::create(
            [
                'nama'=>$nama,
                'alamat'=>$alamat,
                'koordinat'=>$koordinat
            ]
        );
        return [
            $nama,
            $alamat,
            $koordinat
        ];
    }

    public function sekolahbyId(Request $request)
    {
        $id = $request->id;
        $sekolah=Sekolah::find($id);
        return $sekolah;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $nama = $request->nama;
        $alamat = $request->alamat;
        $koordinat = $request->koordinat;
        $id = $request->id;
        $sekolah=Sekolah::find($id);
        $sekolah->update(
            [
                'nama'=>$nama,
                'alamat'=>$alamat,
                'koordinat'=>$koordinat
            ]
            );
        return [
            $nama,
            $alamat,
            $koordinat
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah, Request $request)
    {
        $id = $request->id;
        $sekolah=Sekolah::find($id);
        $sekolah->delete();
    }
}
