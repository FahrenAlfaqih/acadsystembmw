<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilais';
    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'guru_id',
        'semester_id',
        'kelas_id',
        'nilai_harian',
        'nilai_uts',
        'nilai_uas',
        'rata_rata',
        'grade',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
