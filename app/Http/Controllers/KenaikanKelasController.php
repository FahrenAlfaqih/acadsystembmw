<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\RiwayatKelas;
use App\Models\Semester;
use App\Models\Siswa;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KenaikanKelasController extends Controller
{
    public function dataNilaiKelas(Request $request)
    {
        $kelasId = auth()->user()->guru->kelas_id;
        $kelas = Kelas::find($kelasId);

        $siswa = Siswa::with(['nilai', 'presensi'])
            ->where('kelas_id', $kelasId)
            ->get();

        $siswa = $siswa->map(function ($item) {
            $totalNilai = 0;
            $jumlahMapel = 0;

            foreach ($item->nilai as $nilai) {
                $nilaiAkhir = ($nilai->nilai_harian + $nilai->nilai_uts + $nilai->nilai_uas) / 3;
                $totalNilai += $nilaiAkhir;
                $jumlahMapel++;
            }

            $item->rata_rata = $jumlahMapel > 0 ? round($totalNilai / $jumlahMapel, 2) : 0;

            if (!$item->relationLoaded('presensi') || is_null($item->presensi)) {
                $item->setRelation('presensi', collect());
            }

            return $item;
        });

        // Urutkan siswa berdasarkan rata-rata nilai tertinggi dulu (ranking terbaik)
        $siswaRanking = $siswa->sortByDesc('rata_rata')->values();

        foreach ($siswaRanking as $index => $item) {
            $item->ranking = $index + 1;
        }

        $sort = $request->input('sort');
        if ($sort === 'nama_asc') {
            $siswa = $siswa->sortBy('nama')->values();
        } elseif ($sort === 'nama_desc') {
            $siswa = $siswa->sortByDesc('nama')->values();
        } elseif ($sort === 'ranking_asc') {
            $siswa = $siswa->sortByDesc('rata_rata')->values();
        } elseif ($sort === 'ranking_desc') {
            $siswa = $siswa->sortBy('rata_rata')->values();
        } else {
            $siswa = $siswa->sortByDesc('rata_rata')->values();
        }

        $siswa = $siswa->map(function ($item) use ($siswaRanking) {
            $rankItem = $siswaRanking->firstWhere('id', $item->id);
            $item->ranking = $rankItem ? $rankItem->ranking : null;
            return $item;
        });

        return view('walikelas.siswa-nilai', compact('siswa', 'kelas'));
    }

    public function dataPresensiKelas(Request $request)
    {
        $kelasId = auth()->user()->guru->kelas_id;
        $kelas = Kelas::find($kelasId);
        $mapelId = $request->input('mapel_id');

        $query = Siswa::with(['presensi' => function ($q) use ($mapelId) {
            if ($mapelId) {
                $q->where('mapel_id', $mapelId);
            }
        }])->where('kelas_id', $kelasId);

        $siswa = $query->get();

        $mapel = Mapel::all();

        return view('walikelas.siswa-presensi', compact('siswa', 'mapel', 'kelas', 'mapelId'));
    }

    public function formNaikKelas()
    {
        $kelasId = auth()->user()->guru->kelas_id;
        $siswa = Siswa::with('kelas')
            ->where('kelas_id', $kelasId)
            ->get();

        $kelas = Kelas::all();
        $kelasSaatIni = Kelas::find($kelasId);

        $tahunAjaran = Semester::where('tipe', 'Genap')
            ->distinct()
            ->pluck('tahun_ajaran');
        $semesterAktif = Semester::latest()->first();

        return view('kenaikan_kelas.index', compact('siswa', 'kelas', 'kelasSaatIni', 'tahunAjaran'));
    }


    public function prosesNaikKelas(Request $request)
    {
        $request->validate([
            'siswa_ids' => 'required|array',
            'siswa_ids.*' => 'exists:siswa,id',
            'kelas_baru_id' => 'required|exists:kelas,id',
            'tahun_ajaran' => 'required|string',
        ]);

        foreach ($request->siswa_ids as $siswaId) {
            $siswa = Siswa::findOrFail($siswaId);

            // Update kelas_id di tabel nilai
            Nilai::where('siswa_id', $siswa->id)->update([
                'kelas_id' => $siswa->kelas_id,
            ]);

            // Update kelas_id di tabel presensi
            Presensi::where('siswa_id', $siswa->id)->update([
                'kelas_id' => $siswa->kelas_id,
            ]);

            // Simpan riwayat kelas
            RiwayatKelas::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $siswa->kelas_id,
                'tahun_ajaran' => $request->tahun_ajaran,
                'naik_kelas' => true,
            ]);

            // Naikkan siswa ke kelas baru
            $siswa->update([
                'kelas_id' => $request->kelas_baru_id,
            ]);
        }
        Alert::success('Berhasil', 'Kenaikan kelas berhasil diproses untuk semua siswa yang dipilih!');
        return redirect()->back();
    }
}
