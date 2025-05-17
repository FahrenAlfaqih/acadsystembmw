<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;

class RaporController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('rapor.index', compact('kelas'));
    }

    public function preview($kelasId)
    {
        $siswa = Siswa::where('kelas_id', $kelasId)->get();
        $kelas = Kelas::findOrFail($kelasId);

        return view('rapor.preview', compact('siswa', 'kelas'));
    }

    public function cetakPdf($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $semester = Semester::where('is_aktif', 1)->first();

        // Muat siswa beserta nilai yang terkait dengan kelas & semester ini
        $siswaList = Siswa::with(['nilai' => function ($query) use ($kelasId, $semester) {
            $query->where('kelas_id', $kelasId)
                ->where('semester_id', $semester->id);
        }])->where('kelas_id', $kelasId)->get();

        // Hitung rata-rata dan ranking
        $siswaWithAverage = $siswaList->map(function ($siswa) {
            $siswa->rata_rata = $siswa->nilai->avg('rata_rata') ?? 0;
            return $siswa;
        })->sortByDesc('rata_rata')->values();

        foreach ($siswaWithAverage as $index => $siswa) {
            $siswa->ranking = $index + 1;
        }

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $html = view('rapor.pdf', [
            'siswa' => $siswaWithAverage,
            'kelas' => $kelas,
            'semester' => $semester,
        ])->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("rapor_kelas_{$kelas->nama_kelas}.pdf", ["Attachment" => true]);
    }

    public function cetakPdfPerSiswa($kelasId, $siswaId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $siswa = Siswa::findOrFail($siswaId);
        $semester = Semester::where('is_aktif', 1)->first();

        $nilai = Nilai::where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('semester_id', $semester->id)
            ->get();

        $presensi = $siswa->presensi()->where('kelas_id', $kelasId)->get();
        $rataSiswa = $nilai->avg('rata_rata') ?? 0;

        // Hitung ranking berdasarkan nilai rata-rata per siswa di kelas & semester yg sama
        $rankingList = Siswa::with(['nilai' => function ($query) use ($kelasId, $semester) {
            $query->where('kelas_id', $kelasId)
                ->where('semester_id', $semester->id);
        }])
            ->where('kelas_id', $kelasId)
            ->get()
            ->map(function ($item) {
                $item->rata_rata = $item->nilai->avg('rata_rata') ?? 0;
                return $item;
            })
            ->sortByDesc('rata_rata')
            ->values();

        $ranking = 0;
        foreach ($rankingList as $index => $item) {
            if ($item->id == $siswaId) {
                $ranking = $index + 1;
                break;
            }
        }

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $html = view('rapor.pdf_siswa', compact('siswa', 'kelas', 'nilai', 'presensi', 'semester', 'rataSiswa', 'ranking'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("rapor_{$siswa->nama}.pdf", ["Attachment" => true]);
    }
}
