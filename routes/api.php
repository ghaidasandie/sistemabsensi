<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SekolahController;
use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return 'test';
});

Route::get('sekolah',[SekolahController::class,'index']);
Route::post('sekolah',[SekolahController::class,'store']);
Route::get('sekolahbyId',[SekolahController::class,'sekolahbyId']);
Route::put('update',[SekolahController::class,'update']);
Route::delete('delete',[SekolahController::class,'destroy']);
Route::post('absensi', function(Request $request){
  $nisn=$request->nisn;
        $status=$request->status;
        $koordinat=$request->koordinat;
        $absensi=Absensi::create([
            'nisn'=>$nisn,
            'status'=>$status,
            'koordinat'=>$koordinat
        ]);
        return $absensi;
})->middleware('auth:sanctum');
Route::post('login', function (Request $request) {
   $nisn = $request->nisn;
   $tanggal_lahir = $request->tanggal_lahir;
   $siswa=Siswa::where('nisn','=',$nisn)->first();
   if($siswa){
     if( $siswa->tanggal_lahir===$tanggal_lahir){
        return response()->json(['siswa'=>$siswa]);
     }
     return response()->json(['ERORR'=>'Data Invalid'],400);
   }
});
