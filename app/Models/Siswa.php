<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;
    // protected $guarded=['id'];
    protected $fillable = ['nisn', 'nama' ,'tanggal_lahir', 'jenis_kelamin', 'alamat', 'koordinat'];
    public function absensis(){
        return $this->HasMany(Absensi::class,'nisn','nisn');
    }
}
