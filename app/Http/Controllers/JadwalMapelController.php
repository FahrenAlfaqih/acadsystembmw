<?php

namespace App\Http\Controllers;

use App\Models\JadwalMapel;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Semester;
use App\Models\Siswa;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalMapelController extends Controller
{
    public function index()
    {
        $semesterAktif = Semester::where('is_aktif', 1)->first();

        if (!$semesterAktif) {
            return view('jadwal.index', ['jadwalPerSemester' => collect(), 'semesterAktif' => null]);
        }

        $jadwal = JadwalMapel::with(['kelas', 'mapel', 'guru', 'semester'])
            ->where('semester_id', $semesterAktif->id)
            ->get();

        $jadwalPerSemester = collect([$semesterAktif->nama => $jadwal]);

        return view('jadwal.index', compact('jadwalPerSemester', 'semesterAktif'));
    }

    public function indexJadwalSiswa()
    {
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        $semesterAktif = Semester::where('is_aktif', 1)->first();

        if (!$semesterAktif) {
            return view('jadwal.index-siswa', ['jadwal' => collect(), 'kelasSiswa' => $siswa->kelas]);
        }

        $jadwal = JadwalMapel::with(['mapel', 'guru'])
            ->where('kelas_id', $siswa->kelas_id)
            ->where('semester_id', $semesterAktif->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('jadwal.index-siswa', [
            'jadwal' => $jadwal,
            'kelasSiswa' => $siswa->kelas,
        ]);
    }


    public function create()
    {
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $guru = Guru::all();
        $semesterAktif = Semester::where('is_aktif', '1')->first();

        if (!$semesterAktif) {
            return redirect()->back()->withErrors(['semester_id' => 'Tidak ada semester aktif yang ditemukan.']);
        }

        return view('jadwal.create', compact('kelas', 'mapels', 'guru', 'semesterAktif'));
    }

    public function store(Request $request)
    {
        $semesterAktif = Semester::where('is_aktif', '1')->first();

        if (!$semesterAktif) {
            return redirect()->back()->withErrors(['semester_id' => 'Tidak ada semester aktif yang ditemukan.']);
        }

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:guru,id',
            'semester_id' => 'required|exists:semesters,id|in:' . $semesterAktif->id,
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Cek apakah ada jadwal bentrok
        $jadwalBentrok = JadwalMapel::where('kelas_id', $request->kelas_id)
            ->where('semester_id', $semesterAktif->id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        if ($jadwalBentrok) {
            Alert::error('Gagal', 'Jadwal bentrok dengan jadwal lain pada hari dan jam yang sama.');
            return redirect()->back()->withInput();
        }

        // Simpan jika tidak bentrok
        JadwalMapel::create([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'semester_id' => $semesterAktif->id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        Alert::success('Berhasil', 'Data jadwal mata pelajaran berhasil ditambahkan!');
        return redirect()->route('jadwal.index');
    }

    public function edit($id)
    {
        $jadwal = JadwalMapel::with(['kelas', 'mapel', 'guru', 'semester'])->findOrFail($id);
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        $guru = Guru::all();
        $semesterAktif = Semester::where('is_aktif', '1')->first();

        if (!$semesterAktif) {
            return redirect()->back()->withErrors(['semester_id' => 'Tidak ada semester aktif yang ditemukan.']);
        }

        return view('jadwal.update', compact('jadwal', 'kelas', 'mapels', 'guru', 'semesterAktif'));
    }

    public function update(Request $request, $id)
    {
        $semesterAktif = Semester::where('is_aktif', '1')->first();

        if (!$semesterAktif) {
            return redirect()->back()->withErrors(['semester_id' => 'Tidak ada semester aktif yang ditemukan.']);
        }

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mapels,id',
            'guru_id' => 'required|exists:guru,id',
            'semester_id' => 'required|exists:semesters,id|in:' . $semesterAktif->id,
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwal = JadwalMapel::findOrFail($id);

        $jadwal->update([
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $request->guru_id,
            'semester_id' => $semesterAktif->id,
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);
        Alert::success('Berhasil', 'Data jadwal mata pelajaran berhasil diperbarui!');

        return redirect()->route('jadwal.index');
    }

    public function destroy($id)
    {
        $jadwal = JadwalMapel::findOrFail($id);
        $jadwal->delete();
        Alert::success('Berhasil', 'Data jadwal mata pelajaran berhasil dihapus!');

        return redirect()->route('jadwal.index');
    }

    public function filterBySemester(Request $request)
    {
        $semesterId = $request->get('semester_id');
        $semesterDipilih = Semester::find($semesterId);

        if (!$semesterDipilih) {
            return redirect()->back()->with('error', 'Semester tidak ditemukan.');
        }

        $jadwal = JadwalMapel::with(['kelas', 'mapel', 'guru', 'semester'])
            ->where('semester_id', $semesterId)
            ->get();

        $jadwalPerSemester = collect([$semesterDipilih->nama => $jadwal]);
        $semesterAktif = Semester::where('is_aktif', 1)->first();
        $semesters = Semester::all();

        return view('jadwal.index', compact('jadwalPerSemester', 'semesterAktif', 'semesters', 'semesterDipilih'));
    }
}
