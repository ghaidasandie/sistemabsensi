<?php

use App\Http\Controllers\SiswaController;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\AbsensiController;

Route::get('/login', function () {
    return view('login');
})->middleware('guest')->name('login');

Route::post('/login', function (Request $request) {
    $email = $request->email;
    $password = $request->password;
    $credential = [
        'email' => $email,
        'password' => $password
    ];
    Auth::attempt($credential);
    return redirect('/dashboard');
});

Route::get('/admin', function () {
    $siswas = Siswa::paginate(5);
    return view('admin', ['siswas' => $siswas]);
})->middleware('auth');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->withoutMiddleware(
    VerifyCsrfToken::class
)->middleware('auth');

Route::post('/siswa', function (Request $request) {
    $nisn = $request->nisn;
    $nama = $request->nama;
    $jenis_kelamin = $request->jenis_kelamin;
    $alamat = $request->alamat;
    $koordinat = $request->koordinat;

    Siswa::create(
        [
            'nisn' => $nisn,
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'alamat' => $alamat,
            'koordinat' => $koordinat
        ]
    );
    return redirect('/admin');
})->middleware('auth');

//** */ Route Absensi
Route::get('/absensi', function () {
    $absensis = Absensi::all();
    $siswas = Siswa::all(); // Mengambil data siswa untuk dropdown NISN
    return view('absensi', ['absensis' => $absensis, 'siswas' => $siswas]);
})->middleware('auth');

// Menyimpan Absensi menggunakan Route::resource yang otomatis sudah ada
Route::resource('absensi', AbsensiController::class)->middleware('auth');

/// Rute untuk update absensi (metode PUT)
Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');



Route::get('/dashboard', function () {
    $siswas = Siswa::all();
    return view('dashboard', ['siswas' => $siswas]);
})->middleware('auth');


Route::get('/', function (Request $request) {
    //Generate sanctum token
    $token = auth()->user()->createToken('absensi')->plainTextToken;
    return view('home',['token'=>$token]);
})->middleware('auth');

Route::get('/absensi', function () {
    $absensis = Absensi::all();
    return view('absensi', ['absensis' => $absensis]);
})->middleware('auth');

Route::resource('siswa', SiswaController::class);
Route::put('/siswa/{id}', [SiswaController::class, 'update'])->name('siswa.update');
Route::put('/siswa/{id}', [SiswaController::class, 'update'])->middleware('auth')->name('siswa.update');

Route::resource('absensi', AbsensiController::class);
Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update');
Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->middleware('auth')->name('absensi.update');




