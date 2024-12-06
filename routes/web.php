<?php

use App\Models\Siswa;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    $siswas = Siswa::all();
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

Route::get('/dashboard', function () {
    $siswas = Siswa::all();
    return view('dashboard', ['siswas' => $siswas]);
})->middleware('auth');

Route::get('/', function (Request $request) {
    $search = $request->search;
    if ($search) {
        $qrcode = QrCode::generate('Hai');
        $siswas = Siswa::where('nisn','=',$search)->get();
        return view('home', ['siswas' => $siswas, 'qrcode' => $qrcode]);
    } else {
        $qrcode = QrCode::generate('Hai');
        $siswas = [];
        return view('home', ['siswas' => $siswas, 'qrcode' => $qrcode]);
    }
});
