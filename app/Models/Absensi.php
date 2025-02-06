<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absensi extends Model
{
    use HasFactory;
    // protected $guarded=['id'];
    protected $fillable = ['nisn', 'status', 'koordinat'];
    public function siswa(){
        return $this->belongsTo(Siswa::class,'nisn','nisn');
    }
}
