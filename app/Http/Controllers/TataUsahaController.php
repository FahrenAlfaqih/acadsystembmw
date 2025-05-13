<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Sekolah;
use App\Models\Siswa;
use Illuminate\Http\Request;

class TataUsahaController extends Controller
{
    public function dashboard()
    {
        $sekolah = Sekolah::first();
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalMapel = Mapel::count();
        $totalKelas = Kelas::count();

        $jumlahGuruLaki = Guru::where('jenis_kelamin', 'Laki-laki')->count();
        $jumlahGuruPerempuan = Guru::where('jenis_kelamin', 'Perempuan')->count();

        $jumlahSiswaLaki = Siswa::where('jenis_kelamin', 'Laki-laki')->count();
        $jumlahSiswaPerempuan = Siswa::where('jenis_kelamin', 'Perempuan')->count();


        return view('dashboard.tatausaha', compact(
            'totalGuru',
            'totalSiswa',
            'totalMapel',
            'totalKelas',
            'sekolah',
            'jumlahGuruLaki',
            'jumlahGuruPerempuan',
            'jumlahSiswaLaki',
            'jumlahSiswaPerempuan'
        ));
    }
}
