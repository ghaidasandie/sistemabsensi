<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SekolahController;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', function () {
    return 'test';
});

Route::get('sekolah',[SekolahController::class,'index']);
Route::get('sekolahbyId',[SekolahController::class,'sekolahbyId']);
Route::post('absensi', function(Request $request){
    if(!Status::first()->updated_at->isSameDay(Carbon::now())){
        return response()->json(['message'=>'bukan waktu absen'],400);
    };
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

Route::get("cek-jam",function(){
    $now = new DateTime("now", new DateTimeZone("Asia/Jakarta"));
    $now = $now->format("H:i:s");

    $status = Status::first();

    if (!$status) {
        return response()->json(["message" => "Data status tidak ditemukan"], 404);
    }

    $start = $status->mulai;
    $end = $status->selesai;
    // $now = '08:00:00';

    $isValid = ($now >= $start && $now <= $end);
    return response()->json([
        "now" => $now,
        "start" => $start,
        "end" => $end,
        "isValid" => $isValid
    ]);


});
Route::get('cek-status',function(){
    $status = Status::first()->status;
    return response()->json([
        'status'=>$status
    ]);
});
Route::get('/generate-token', function () {
    //Generate sanctum token
    $user = User::first();
    $token = $user->createToken('absensi')->plainTextToken;
    return response()->json([
        'token' => $token
    ]);
});
