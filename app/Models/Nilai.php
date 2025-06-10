<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilais';

    // Menambahkan kolom baru ke dalam $fillable
    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'guru_id',
        'semester_id',
        'kelas_id',
        'nilai_harian',
        'nilai_ulangan_harian',
        'nilai_quiz',
        'nilai_tugas',
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

    /**
     * Method untuk menghitung nilai harian berdasarkan nilai ulangan, quiz, dan tugas
     */
    public function calculateNilaiHarian()
    {
        $nilai_ulangan_harian = $this->nilai_ulangan_harian ?? 0;
        $nilai_quiz = $this->nilai_quiz ?? 0;
        $nilai_tugas = $this->nilai_tugas ?? 0;

        // Misalnya bobot nilai: ulangan 40%, quiz 30%, tugas 30%
        return ($nilai_ulangan_harian * 0.4) + ($nilai_quiz * 0.3) + ($nilai_tugas * 0.3);
    }
}
