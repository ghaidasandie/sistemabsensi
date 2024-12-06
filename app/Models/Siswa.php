<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // protected $guarded=['id'];
    protected $fillable = ['nisn', 'nama', 'jenis_kelamin', 'alamat', 'koordinat'];
}
