<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;
    protected $table = 'presensi';

    protected $fillable = [
        'guru_id',
        'kelas_id',
        'mapel_id',
        'siswa_id',
        'semester_id',
        'tanggal',
        'pertemuan_ke',
        'status_kehadiran',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
