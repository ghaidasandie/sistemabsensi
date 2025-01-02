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
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah, Request $request)
    {
      
    }
}
