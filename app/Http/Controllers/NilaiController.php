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
        // Validasi array
        $request->validate([
            'siswa_id' => 'required|array',
            'nilai_ulangan_harian' => 'array',
            'nilai_tugas' => 'array',
            'nilai_quiz' => 'array',
            'nilai_uts' => 'array',
            'nilai_uas' => 'array',
        ]);

        $guru_id = auth()->user()->guru->id;

        foreach ($request->siswa_id as $i => $siswa_id) {
            $nilai_ulangan_harian = $request->nilai_ulangan_harian[$i] ?? 0;
            $nilai_quiz = $request->nilai_quiz[$i] ?? 0;
            $nilai_tugas = $request->nilai_tugas[$i] ?? 0;
            $nilai_uts = $request->nilai_uts[$i] ?? 0;
            $nilai_uas = $request->nilai_uas[$i] ?? 0;

            $nilai_harian = ($nilai_ulangan_harian * 0.4) + ($nilai_quiz * 0.3) + ($nilai_tugas * 0.3);
            $rata_rata = ($nilai_harian + $nilai_uts + $nilai_uas) / 3;
            $grade = $this->getGrade($rata_rata);

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'mapel_id' => $mapel_id,
                    'guru_id' => $guru_id,
                    'semester_id' => $semester_id,
                    'kelas_id' => $kelas_id,
                ],
                [
                    'nilai_harian' => $nilai_harian,
                    'nilai_ulangan_harian' => $nilai_ulangan_harian,
                    'nilai_quiz' => $nilai_quiz,
                    'nilai_tugas' => $nilai_tugas,
                    'nilai_uts' => $nilai_uts,
                    'nilai_uas' => $nilai_uas,
                    'rata_rata' => $rata_rata,
                    'grade' => $grade,
                ]
            );
        }

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
