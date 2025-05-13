<?php

namespace App\Http\Controllers;

use App\Models\JadwalMapel;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Presensi;
use App\Models\Semester;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;




class PresensiController extends Controller
{
    public function index()
    {
        $presensi = Presensi::with(['siswa', 'guru', 'kelas', 'mapel'])->get();
        return view('presensi.index', compact('presensi'));
    }
    public function create($kelas_id, $mapel_id, $semester_id)
    {
        $kelas = Kelas::find($kelas_id);
        $mapel = Mapel::find($mapel_id);
        $semester = Semester::find($semester_id);
        $siswaList = Siswa::where('kelas_id', $kelas_id)->get();

        return view('presensi.create', compact('kelas', 'mapel', 'semester', 'siswaList', 'kelas_id', 'mapel_id', 'semester_id'));
    }


    public function store(Request $request, $kelas_id, $mapel_id, $semester_id)

    {
        $request->validate([
            'tanggal' => 'required|date',
            'pertemuan_ke' => 'required|integer|min:1|max:36',
            'status_kehadiran.*' => 'required|in:Hadir,Alpha,Izin,Sakit',
            'siswa_id' => 'required|array',
        ]);

        foreach ($request->siswa_id as $key => $siswa_id) {
            $status = $request->status_kehadiran[$siswa_id] ?? null;
            Presensi::create([
                'siswa_id' => $siswa_id,
                'guru_id' => auth()->user()->guru->id,
                'kelas_id' => $kelas_id,
                'mapel_id' => $mapel_id,
                'semester_id' => $semester_id,
                'status_kehadiran' => $status,
                'tanggal' => $request->tanggal,
                'pertemuan_ke' => $request->pertemuan_ke,
            ]);
        }
        Alert::success('Berhasil', 'Data Presensi berhasil disimpan!');

        return redirect()->route('guru.dashboard');
    }


    public function rekapKelas($kelas_id, $semester_id, $mapel_id)
    {
        $guruId = auth()->user()->guru->id;
    
        $kelas    = Kelas::findOrFail($kelas_id);
        $mapel    = Mapel::findOrFail($mapel_id); 
        $semester = Semester::findOrFail($semester_id);
        $siswaList = Siswa::where('kelas_id', $kelas_id)->get();
    
        $presensiData = Presensi::where('kelas_id', $kelas_id)
            ->where('guru_id', $guruId)
            ->where('semester_id', $semester_id)
            ->with('siswa')
            ->orderBy('pertemuan_ke')
            ->get()
            ->groupBy('pertemuan_ke');
    

        return view('presensi.rekap-kelas', compact('kelas', 'mapel', 'siswaList', 'presensiData', 'semester_id', 'semester'));
    }
    
}
