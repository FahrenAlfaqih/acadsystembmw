<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semesters';
    protected $fillable = ['nama', 'tahun_ajaran', 'tipe', 'is_aktif'];

    public function nilai()
    {
        return $this->hasMany(Nilai::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }
}
