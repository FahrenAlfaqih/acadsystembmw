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
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class RaporController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role == 'guru') {
            $kelas = Kelas::where('id', $user->guru->kelas_id)->get();
            return redirect()->route('rapor.preview', $user->guru->kelas_id);
        } elseif ($user->role == 'tatausaha') {
            $kelas = Kelas::all();
            return view('rapor.index', compact('kelas'));
        } else {
            abort(403, 'Unauthorized');
        }
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

    public function cetakWordPerSiswa($kelasId, $siswaId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $siswa = Siswa::findOrFail($siswaId);
        $semester = Semester::where('is_aktif', 1)->first();

        $nilai = Nilai::where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('semester_id', $semester->id)
            ->get();

        $presensi = $siswa->presensi()->where('kelas_id', $kelasId)->get();

        // Buat dokumen Word
        $phpWord = new PhpWord();
        $phpWord->addTableStyle('TabelRapor', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ]);
        $section = $phpWord->addSection();

        // Heading Tengah
        $section->addText('RAPOR PESERTA DIDIK', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addText('KURIKULUM MERDEKA', ['bold' => true], ['alignment' => 'center']);
        $section->addText('SMA BINA MITRA WAHANA', ['bold' => true], ['alignment' => 'center']);
        $section->addText($semester->nama . ' Tahun Pelajaran ' . $semester->tahun_ajaran, [], ['alignment' => 'center']);
        $section->addTextBreak();

        // I. Identitas Peserta Didik
        $section->addText('I. Identitas Peserta Didik', ['bold' => true]);

        $identitasTable = $section->addTable('TabelRapor');
        $identitasTable->addRow();
        $identitasTable->addCell(3000)->addText('Komponen');
        $identitasTable->addCell(7000)->addText('Keterangan');

        $identitas = [
            'Nama Peserta Didik' => $siswa->nama,
            'NISN' => $siswa->nisn,
            'Kelas' => $kelas->nama_kelas,
            'Sekolah' => 'SMA Bina Mitra Wahana',
            'Semester' => $semester->nama,
            'Tahun Pelajaran' => $semester->tahun_ajaran,
            'Alamat' => $siswa->alamat ?? '-',
        ];

        foreach ($identitas as $key => $value) {
            $identitasTable->addRow();
            $identitasTable->addCell(3000)->addText($key);
            $identitasTable->addCell(7000)->addText($value);
        }

        // II. Nilai dan Capaian Kompetensi
        $section->addTextBreak(1);
        $section->addText('II. Daftar Nilai dan Capaian Kompetensi', ['bold' => true]);

        $nilaiTable = $section->addTable('TabelRapor');
        $nilaiTable->addRow();
        $nilaiTable->addCell(500)->addText('No');
        $nilaiTable->addCell(3000)->addText('Mata Pelajaran');
        $nilaiTable->addCell(1000)->addText('Nilai Akhir');
        $nilaiTable->addCell(5000)->addText('Deskripsi Capaian Kompetensi');

        foreach ($nilai as $i => $n) {
            $nilaiTable->addRow();
            $nilaiTable->addCell(500)->addText($i + 1);
            $nilaiTable->addCell(3000)->addText($n->mapel->nama_mapel ?? '-');
            $nilaiTable->addCell(1000)->addText($n->rata_rata ?? '-');
            $nilaiTable->addCell(5000)->addText(''); // kosong untuk diisi manual
        }

        // III. Ekstrakurikuler (Kosong)
        $section->addTextBreak(1);
        $section->addText('III. Kegiatan Ekstrakurikuler', ['bold' => true]);

        $ekskulTable = $section->addTable('TabelRapor');
        $ekskulTable->addRow();
        $ekskulTable->addCell(500)->addText('No');
        $ekskulTable->addCell(4000)->addText('Kegiatan Ekstrakurikuler');
        $ekskulTable->addCell(4000)->addText('Keterangan');

        for ($i = 1; $i <= 3; $i++) {
            $ekskulTable->addRow();
            $ekskulTable->addCell(500)->addText($i);
            $ekskulTable->addCell(4000)->addText('');
            $ekskulTable->addCell(4000)->addText('');
        }

        // IV. Ketidakhadiran
        $countAlpa = $presensi->where('status_kehadiran', 'Alpha')->count();
        $countSakit = $presensi->where('status_kehadiran', 'Sakit')->count();
        $countIzin = $presensi->where('status_kehadiran', 'Izin')->count();

        $section->addTextBreak(1);
        $section->addText('IV. Ketidakhadiran', ['bold' => true]);

        $absenTable = $section->addTable('TabelRapor');
        $absenTable->addRow();
        $absenTable->addCell(4000)->addText('Keterangan');
        $absenTable->addCell(4000)->addText('Jumlah Hari');

        $absenTable->addRow();
        $absenTable->addCell(4000)->addText('Sakit');
        $absenTable->addCell(4000)->addText("$countSakit Hari");

        $absenTable->addRow();
        $absenTable->addCell(4000)->addText('Izin');
        $absenTable->addCell(4000)->addText("$countIzin Hari");

        $absenTable->addRow();
        $absenTable->addCell(4000)->addText('Tanpa Keterangan (Alpha)');
        $absenTable->addCell(4000)->addText("$countAlpa Hari");

        // V. Catatan Guru
        $section->addTextBreak(1);
        $section->addText('V. Catatan Guru', ['bold' => true]);
        $section->addTextBreak(3);

        // VI. Tanda Tangan
        $section->addText('VI. Tanda Tangan', ['bold' => true]);
        $ttdTable = $section->addTable('TabelRapor');
        $ttdTable->addRow();
        $ttdTable->addCell(3000)->addText('Orang Tua / Wali', ['bold' => true], ['alignment' => 'center']);
        $ttdTable->addCell(3000)->addText('Kepala Sekolah', ['bold' => true], ['alignment' => 'center']);
        $ttdTable->addCell(3000)->addText('Wali Kelas', ['bold' => true], ['alignment' => 'center']);

        $ttdTable->addRow();
        // Orang Tua / Wali
        $cell1 = $ttdTable->addCell(3000);
        $cell1->addTextBreak(4);
        $cell1->addText('(....................................)');

        // Kepala Sekolah
        $cell2 = $ttdTable->addCell(3000);
        $cell2->addTextBreak(4);
        $cell2->addText('(....................................)');

        // Wali Kelas
        $cell3 = $ttdTable->addCell(3000);
        $cell3->addTextBreak(4);
        $cell3->addText('(....................................)');
        // Simpan ke file sementara
        $filename = 'rapor_' . $siswa->nama . '.docx';
        $tempFile = storage_path($filename);
        $phpWord->save($tempFile, 'Word2007');

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
