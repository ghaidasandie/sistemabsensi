<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable=['nisn','status','koordinat'];
    public function siswa(){
        return $this->belongsTo(Siswa::class,'nisn');
    }
}
