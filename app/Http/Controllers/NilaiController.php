<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class NilaiController extends Controller
{

    public function create($kelas_id, $mapel_id, $semester_id)
    {
        $siswaList = Siswa::where('kelas_id', $kelas_id)->get();
        $mapel = Mapel::findOrFail($mapel_id);
        $kelas = Kelas::findOrFail($kelas_id);
        $semester = Semester::findOrFail($semester_id);

        return view('nilai.create', compact('siswaList', 'mapel', 'kelas', 'kelas_id', 'mapel_id', 'semester', 'semester_id'));
    }

    public function store(Request $request, $kelas_id, $mapel_id, $semester_id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nilai_harian' => 'nullable|numeric',
            'nilai_uts' => 'nullable|numeric',
            'nilai_uas' => 'nullable|numeric',
        ]);

        $nilai_harian = $request->nilai_harian ?? 0;
        $nilai_uts = $request->nilai_uts ?? 0;
        $nilai_uas = $request->nilai_uas ?? 0;

        $rata_rata = ($nilai_harian + $nilai_uts + $nilai_uas) / 3;
        $grade = $this->getGrade($rata_rata);

        $guru_id = auth()->user()->guru->id;


        $nilai = Nilai::updateOrCreate(
            [
                'siswa_id' => $request->siswa_id,
                'mapel_id' => $mapel_id,
                'guru_id' => $guru_id,
                'semester_id' => $semester_id,
                'kelas_id' => $kelas_id,
            ],
            [
                'nilai_harian' => $nilai_harian,
                'nilai_uts' => $nilai_uts,
                'nilai_uas' => $nilai_uas,
                'rata_rata' => $rata_rata,
                'grade' => $grade,
            ]
        );
        Alert::success('Berhasil', 'Data Nilai berhasil disimpan!');
        return redirect()->route('guru.dashboard');
    }


    public function getGrade($rataRata)
    {
        if ($rataRata >= 85) {
            return 'A';
        } elseif ($rataRata >= 80) {
            return 'AB';
        } elseif ($rataRata >= 70) {
            return 'B';
        } elseif ($rataRata >= 60) {
            return 'C';
        } elseif ($rataRata >= 50) {
            return 'D';
        } else {
            return 'E';
        }
    }



    public function rekapKelas($kelas_id, $semester_id, $mapel_id)
    {
        $guruId = auth()->user()->guru->id;

        $kelas     = Kelas::findOrFail($kelas_id);
        $mapel     = Mapel::findOrFail($mapel_id);
        $semester  = Semester::findOrFail($semester_id);
        $siswaList = Siswa::where('kelas_id', $kelas_id)->get();

        $nilaiData = Nilai::where('guru_id', $guruId)
            ->where('mapel_id', $mapel_id)
            ->where('semester_id', $semester_id)
            ->whereHas('siswa', fn($q) => $q->where('kelas_id', $kelas_id))
            ->with('siswa')
            ->get();

        return view('nilai.rekap-kelas', compact(
            'kelas',
            'mapel',
            'semester',
            'siswaList',
            'nilaiData'
        ));
    }
}
