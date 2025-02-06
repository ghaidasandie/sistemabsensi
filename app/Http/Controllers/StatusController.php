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

    // Fungsi untuk menandai absensi 'alfa' jika waktu selesai sudah lewat
    private function autoMarkAlfa($mulai, $selesai)
    {
        $now = Carbon::now();
    
        // Pastikan waktu selesai yang diterima memiliki format yang valid
        if ($selesai && Carbon::hasFormat($selesai, 'H:i')) {
            $selesaiTime = Carbon::createFromFormat('H:i', $selesai);
    
            // Tandai siswa yang belum absen jika waktu selesai sudah lewat
            if ($now->greaterThanOrEqualTo($selesaiTime)) {
                // Cari semua siswa yang belum absen dengan status selain hadir, sakit, izin
                $siswaBelumAbsen = Siswa::whereDoesntHave('absensis', function ($query) {
                    $query->whereIn('status', ['h', 's', 'i']); // Status absensi hadir, sakit, izin
                })->get();
    
                // Tandai siswa yang belum absen dengan status 'alfa' saja
                foreach ($siswaBelumAbsen as $siswa) {
                    // Cek apakah siswa sudah absen atau belum
                    $absensi = Absensi::where('nisn', $siswa->nisn)
                        ->whereIn('status', ['h', 's', 'i']) // Status absensi yang sah
                        ->whereDate('created_at', Carbon::today()) // Cek untuk hari ini
                        ->first();
    
                    // Jika siswa belum absen, beri status 'alfa'
                    if (!$absensi) {
                        Absensi::updateOrCreate(
                            ['nisn' => $siswa->nisn, 'created_at' => $selesaiTime->toDateString()],
                            [
                                'status' => 'a', // 'a' untuk Alfa
                                'koordinat' => $siswa->koordinat, // Koordinat dari tabel siswa
                            ]
                        );
                    }
                }
            }
        }
    }
    

    // Fungsi untuk otomatis mengubah status menjadi 'offline' jika waktu selesai telah lewat
    private function autoChangeToOffline()
    {
        $now = Carbon::now();
        $status = Status::first();

        if ($status && $status->status === 'online') {
            if ($status->selesai) {
                $selesaiTime = Carbon::createFromFormat('H:i', $status->selesai);

                if ($now->greaterThanOrEqualTo($selesaiTime)) {
                    $status->status = 'offline';
                    $status->mulai = null;
                    $status->selesai = null;
                    $status->save();

                    // Pastikan siswa yang belum absen ditandai sebagai 'alfa'
                    $this->autoMarkAlfa(null, $selesaiTime->format('H:i'));
                }
            }
        }
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
