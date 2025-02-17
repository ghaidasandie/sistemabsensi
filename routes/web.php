<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\StatusController;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route untuk halaman login
Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

// Route untuk proses login dengan validasi
// Route untuk halaman login
Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

// Route untuk proses login dengan validasi
Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        return redirect()->route('dashboard'); // Redirect ke dashboard setelah login berhasil
    }

    return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
})->name('login.process');


// Middleware auth untuk rute yang hanya bisa diakses oleh user yang login
Route::middleware('auth')->group(function () {

// Route untuk logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');  // Arahkan ke halaman login setelah logout
})->middleware('auth')->name('logout');

// Rute utama jika belum login (akan mengarah ke login)
Route::get('/', function () {
    return redirect()->route('login'); // Jika belum login, arahkan ke login
});

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Siswa
    Route::resource('siswa', SiswaController::class);
    Route::get('/admin/search', [SiswaController::class, 'search'])->name('siswa.search');

    // Manajemen Absensi
    Route::resource('absensi', AbsensiController::class);

    // Status
    Route::get('/status', [StatusController::class, 'index'])->name('status.index');
    Route::put('/status/update/{id}', [StatusController::class, 'updateStatus'])->name('status.update');

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');

    // Admin Panel
    Route::get('/admin', function () {
        $siswas = Siswa::paginate(5);
        return view('admin', ['siswas' => $siswas]);
    })->name('admin');

    // Halaman home setelah login
    Route::middleware('auth')->get('/qr', function () {
        // Hanya yang sudah login yang bisa mengakses halaman ini
        $token = Auth::user()->createToken('absensi')->plainTextToken;
        return view('home', ['token' => $token]);
    })->name('home');

});
