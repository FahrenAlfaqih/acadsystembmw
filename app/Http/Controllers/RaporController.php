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

        // Dummy kepala sekolah, wali kelas (sesuaikan ke DB kalau ada)
        $kepalaSekolah = "Febrina Olivia, S.Pd";
        $nipKepsek = "....";
        $waliKelas = "Resi Melia, S.Pd";
        $nipWali = "....";
        $namaSekolah = "SMA Bina Mitra Wahana";
        $alamatSekolah = "Jalan Kulim Ujung Nomor 88 B";
        $kota = "Pekanbaru";

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->addTableStyle('TabelRapor', [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
        ]);

        $section = $phpWord->addSection();

        // Header Tengah
        $section->addText('LAPORAN HASIL BELAJAR', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
        $section->addText('(RAPOR)', ['bold' => true], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $styleIdentitas = [
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 30,
        ];
        $phpWord->addTableStyle('TableIdentitas', $styleIdentitas);

        $table = $section->addTable('TableIdentitas');
        $table->addRow();
        $table->addCell(2800)->addText('Nama Peserta Didik');
        $table->addCell(10)->addText(':');
        $table->addCell(4300)->addText($siswa->nama);
        $table->addCell(1500)->addText('Kelas');
        $table->addCell(10)->addText(':');
        $table->addCell(2300)->addText($kelas->nama_kelas);

        $table->addRow();
        $table->addCell(2800)->addText('NISN');
        $table->addCell(10)->addText(':');
        $table->addCell(4300)->addText($siswa->nisn);
        $table->addCell(1500)->addText('Fase');
        $table->addCell(10)->addText(':');
        $table->addCell(2300)->addText('E'); // atau variabel Fase

        $table->addRow();
        $table->addCell(2800)->addText('Sekolah');
        $table->addCell(10)->addText(':');
        $table->addCell(4300)->addText('SMA Bina Mitra Wahana');
        $table->addCell(1500)->addText('Semester');
        $table->addCell(10)->addText(':');
        $table->addCell(2300)->addText($semester->nama);

        $table->addRow();
        $table->addCell(2800)->addText('Alamat');
        $table->addCell(10)->addText(':');
        $table->addCell(4300)->addText('Jalan Kulim Ujung Nomor 88 B');
        $table->addCell(1500)->addText('Tahun Pelajaran');
        $table->addCell(10)->addText(':');
        $table->addCell(2300)->addText($semester->tahun_ajaran);

        $section->addTextBreak(1);


        // Tabel Nilai
        $section->addText(' ', [], ['alignment' => 'center']); // Spasi kecil
        $nilaiTable = $section->addTable('TabelRapor');
        $nilaiTable->addRow();
        $nilaiTable->addCell(400)->addText('No', [], ['alignment' => 'center']);
        $nilaiTable->addCell(3500)->addText('Muatan Pelajaran', [], ['alignment' => 'center']);
        $nilaiTable->addCell(900)->addText('Nilai Akhir', [], ['alignment' => 'center']);
        $nilaiTable->addCell(6000)->addText('Capaian Kompetensi', [], ['alignment' => 'center']);

        foreach ($nilai as $i => $n) {
            $nilaiTable->addRow();
            $nilaiTable->addCell(400)->addText($i + 1, [], ['alignment' => 'center']);
            $nilaiTable->addCell(3500)->addText($n->mapel->nama_mapel ?? '-', [], ['alignment' => 'left']);
            $nilaiTable->addCell(900)->addText($n->rata_rata ?? '-', [], ['alignment' => 'center']);
            $nilaiTable->addCell(6000)->addText($n->catatan_kompetensi ?? '................................................', [], ['alignment' => 'left']);
        }

        $section->addTextBreak(1);

        // Ekstrakurikuler
        $section->addText('Ekstrakurikuler', ['bold' => true]);
        $ekskulTable = $section->addTable('TabelRapor');
        $ekskulTable->addRow();
        $ekskulTable->addCell(400)->addText('No', [], ['alignment' => 'center']);
        $ekskulTable->addCell(3200)->addText('Ekstrakurikuler', [], ['alignment' => 'center']);
        $ekskulTable->addCell(3200)->addText('Keterangan', [], ['alignment' => 'center']);
        // Buat 5 baris kosong seperti gambar
        for ($i = 1; $i <= 5; $i++) {
            $ekskulTable->addRow();
            $ekskulTable->addCell(400)->addText($i, [], ['alignment' => 'center']);
            $ekskulTable->addCell(3200)->addText(' ');
            $ekskulTable->addCell(3200)->addText(' ');
        }

        $section->addTextBreak(1);

        // Tabel Ketidakhadiran
        $section->addText('Ketidakhadiran', ['bold' => true]);
        $absenTable = $section->addTable('TabelRapor');
        $absenTable->addRow();
        $absenTable->addCell(2400)->addText('Keterangan', [], ['alignment' => 'center']);
        $absenTable->addCell(2400)->addText('Hari', [], ['alignment' => 'center']);

        $countSakit = $presensi->where('status_kehadiran', 'Sakit')->count();
        $countIzin = $presensi->where('status_kehadiran', 'Izin')->count();
        $countAlpa = $presensi->where('status_kehadiran', 'Alpha')->count();

        $absenTable->addRow();
        $absenTable->addCell(2400)->addText('Sakit');
        $absenTable->addCell(2400)->addText($countSakit . ' hari');
        $absenTable->addRow();
        $absenTable->addCell(2400)->addText('Izin');
        $absenTable->addCell(2400)->addText($countIzin . ' hari');
        $absenTable->addRow();
        $absenTable->addCell(2400)->addText('Tanpa Keterangan');
        $absenTable->addCell(2400)->addText($countAlpa . ' hari');

        $section->addTextBreak(1);

        // Tanda Tangan Layout
        $tableTTD = $section->addTable();
        $tableTTD->addRow();
        $tableTTD->addCell(3000)->addText('Orang Tua', [], ['alignment' => 'center']);
        $tableTTD->addCell(3000)->addText($kota . ', ' . now()->translatedFormat('d F Y'), [], ['alignment' => 'center']);
        $tableTTD->addCell(3000)->addText('Mengetahui,', [], ['alignment' => 'center']);

        $tableTTD->addRow();
        $tableTTD->addCell(3000)->addTextBreak(3);
        $tableTTD->addCell(3000)->addText('Wali Kelas', [], ['alignment' => 'center']);
        $tableTTD->addCell(3000)->addText('Kepala Sekolah', [], ['alignment' => 'center']);

        $tableTTD->addRow();
        $tableTTD->addCell(3000)->addTextBreak(3);
        $tableTTD->addCell(3000)->addTextBreak(3);
        $tableTTD->addCell(3000)->addTextBreak(3);

        $tableTTD->addRow();
        $tableTTD->addCell(3000)->addText('(....................................)', [], ['alignment' => 'center']);
        $tableTTD->addCell(3000)->addText("{$waliKelas}", [], ['alignment' => 'center']);
        $tableTTD->addCell(3000)->addText("{$kepalaSekolah}", [], ['alignment' => 'center']);

        $tableTTD->addRow();
        $tableTTD->addCell(3000)->addText('');
        $tableTTD->addCell(3000)->addText('NIP. ' . $nipWali, [], ['alignment' => 'center']);
        $tableTTD->addCell(3000)->addText('NIP. ' . $nipKepsek, [], ['alignment' => 'center']);

        // Simpan ke file sementara
        $filename = 'rapor_' . preg_replace('/\s+/', '_', $siswa->nama) . '.docx';
        $tempFile = storage_path($filename);
        $phpWord->save($tempFile, 'Word2007');

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }
}
