<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['nisn', 'nama', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'koordinat'];

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'nisn', 'nisn');
    }
}
