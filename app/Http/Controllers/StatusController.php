<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Status;
use Carbon\Carbon;
use App\Models\Siswa;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        // Panggil autoChangeToOffline untuk memastikan status terbaru
        // $this->autoChangeToOffline();

        // Ambil status saat ini
        $status = Status::first();
        return view('status', compact('status'));
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:offline,online',
            'mulai' => 'required_if:status,online|date_format:H:i',
            'selesai' => 'required_if:status,online|date_format:H:i|after:mulai',
        ]);

        // Update or create status
        $status = Status::firstOrCreate([]);
        $status->status = $request->status;
        $status->mulai = $request->mulai;
        $status->selesai = $request->selesai;
        $status->save();


        // Jika status online, tandai siswa yang belum absen sebagai 'alfa'
        // if ($status->status === 'online') {
        //     $this->autoMarkAlfa($status->mulai, $status->selesai);
        // }

        // Panggil fungsi untuk cek waktu selesai dan ubah status menjadi offline
        // $this->autoChangeToOffline();

        return redirect()->back()->with('success', 'Status absensi berhasil diperbarui.');
    }


    // Fungsi lainnya (create, store, etc) bisa dikosongkan jika tidak diperlukan
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Status $status)
    {
        //
    }
}
