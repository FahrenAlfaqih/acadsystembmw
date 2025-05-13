<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';

    protected $fillable = ['nama_kelas', 'tingkatan', 'wali_kelas_id'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function mapels()
    {
        return $this->belongsToMany(Mapel::class);
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }
}
