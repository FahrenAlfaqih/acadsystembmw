<?php

namespace App\Http\Controllers;

use App\Models\JadwalMapel;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use App\Models\Presensi;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;



class SiswaController extends Controller
{

    public function index()
    {
        $siswa = Siswa::with('user')->get();

        return view('siswa.index', compact('siswa'));
    }



    public function create()
    {
        $kelas = Kelas::all();
        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'nisn' => 'required|unique:siswa,nisn',
        ]);

        // Simpan ke users
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);
        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $pathFoto = $foto->storeAs('foto_pengguna', $namaFile, 'public');
        }

        // Simpan ke siswa
        Siswa::create([
            'user_id' => $user->id,
            'kelas_id' => $request->kelas_id,
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'status' => $request->status,
            'orangtua' => $request->orangtua,
            'foto' => $pathFoto,
        ]);
        Alert::success('Berhasil', 'Data Siswa berhasil disimpan!');

        return redirect()->route('siswa.index');
    }

    public function dashboardSiswa()
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();
        $kelas_id = $siswa->kelas_id;

        // Ambil mapel yang memang diajarkan di kelas siswa
        $jadwalMapelIds = JadwalMapel::where('kelas_id', $kelas_id)
            ->pluck('mapel_id')
            ->toArray();

        // Filter daftar mapel yang sesuai
        $mapelList = Mapel::whereIn('id', $jadwalMapelIds)->get();

        // =================== PRESENSI ====================
        $pertemuanList = Presensi::where('siswa_id', $siswa->id)
            ->whereIn('mapel_id', $jadwalMapelIds)
            ->select('pertemuan_ke')
            ->distinct()
            ->orderBy('pertemuan_ke')
            ->pluck('pertemuan_ke');

        $presensiData = Presensi::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->whereIn('mapel_id', $jadwalMapelIds)
            ->get();

        $presensiMap = [];
        foreach ($presensiData as $presensi) {
            $presensiMap[$presensi->mapel_id][$presensi->pertemuan_ke] = $presensi->status_kehadiran;
        }

        $kehadiranPersen = [];
        foreach ($mapelList as $mapel) {
            $totalPertemuan = 0;
            $totalHadir = 0;
            if (isset($presensiMap[$mapel->id])) {
                foreach ($presensiMap[$mapel->id] as $status) {
                    $totalPertemuan++;
                    if ($status === 'Hadir') {
                        $totalHadir++;
                    }
                }
            }
            $kehadiranPersen[$mapel->id] = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100, 2) : 0;
        }

        // =================== NILAI ====================
        $nilaiList = Nilai::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->whereIn('mapel_id', $jadwalMapelIds)
            ->get();

        $nilaiLabels = [];
        $nilaiRataRata = [];
        foreach ($nilaiList as $nilai) {
            $nilaiLabels[] = $nilai->mapel->nama_mapel;
            $nilaiRataRata[] = round($nilai->rata_rata, 2);
        }

        return view('dashboard.siswa', compact(
            'mapelList',
            'pertemuanList',
            'presensiMap',
            'kehadiranPersen',
            'nilaiList',
            'nilaiLabels',
            'nilaiRataRata'
        ));
    }

    public function presensiIndex(Request $request)
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();
        $kelas_id = $siswa->kelas_id;
        $semester_id = $request->get('semester_id', null);

        if ($semester_id) {
            $mapelIdsPresensiSemester = Presensi::where('siswa_id', $siswa->id)
                ->where('semester_id', $semester_id)
                ->pluck('mapel_id')
                ->unique()
                ->toArray();

            $mapelList = Mapel::whereIn('id', $mapelIdsPresensiSemester)->get();

            $presensiData = Presensi::with('mapel')
                ->where('siswa_id', $siswa->id)
                ->where('semester_id', $semester_id)
                ->whereIn('mapel_id', $mapelIdsPresensiSemester)
                ->get();
        } else {
            $latestSemester = Presensi::where('siswa_id', $siswa->id)
                ->orderBy('semester_id', 'desc')
                ->first();

            if ($latestSemester) {
                $semester_id = $latestSemester->semester_id;

                $mapelIdsPresensiSemester = Presensi::where('siswa_id', $siswa->id)
                    ->where('semester_id', $semester_id)
                    ->pluck('mapel_id')
                    ->unique()
                    ->toArray();

                $mapelList = Mapel::whereIn('id', $mapelIdsPresensiSemester)->get();

                $presensiData = Presensi::with('mapel')
                    ->where('siswa_id', $siswa->id)
                    ->where('semester_id', $semester_id)
                    ->whereIn('mapel_id', $mapelIdsPresensiSemester)
                    ->get();
            } else {
                $mapelList = collect();
                $presensiData = collect();
            }
        }

        // Ambil pertemuan hanya untuk semester aktif
        $pertemuanList = $presensiData
            ->pluck('pertemuan_ke')
            ->unique()
            ->sort()
            ->values();

        $presensiMap = [];
        foreach ($presensiData as $presensi) {
            $presensiMap[$presensi->mapel_id][$presensi->pertemuan_ke] = $presensi->status_kehadiran;
        }

        // Hitung persentase kehadiran
        $kehadiranPersen = [];
        foreach ($mapelList as $mapel) {
            $totalPertemuan = 0;
            $totalHadir = 0;
            if (isset($presensiMap[$mapel->id])) {
                foreach ($presensiMap[$mapel->id] as $status) {
                    $totalPertemuan++;
                    if ($status === 'Hadir') {
                        $totalHadir++;
                    }
                }
            }
            $kehadiranPersen[$mapel->id] = $totalPertemuan > 0 ? round(($totalHadir / $totalPertemuan) * 100, 2) : 0;
        }

        $semesters = Semester::all();

        return view('presensi.index', compact(
            'mapelList',
            'pertemuanList',
            'presensiMap',
            'kehadiranPersen',
            'semesters',
            'semester_id'
        ));
    }



    public function nilaiIndex(Request $request)
    {
        $siswa = Siswa::where('user_id', Auth::id())->first();
        $kelas_id = $siswa->kelas_id;
        $semester_id = $request->get('semester_id', null);

        if ($semester_id) {
            // Ambil mata pelajaran berdasarkan semester yang dipilih
            $mapelIdsPresensiSemester = Presensi::where('siswa_id', $siswa->id)
                ->where('semester_id', $semester_id)
                ->pluck('mapel_id')
                ->unique()
                ->toArray();

            $mapelList = Mapel::whereIn('id', $mapelIdsPresensiSemester)->get();
        } else {
            // Jika semester_id tidak ada, cari semester terakhir
            $latestSemester = Presensi::where('siswa_id', $siswa->id)
                ->orderBy('semester_id', 'desc')
                ->first();

            if ($latestSemester) {
                $semester_id = $latestSemester->semester_id;

                // Ambil mata pelajaran berdasarkan semester terakhir
                $mapelIdsPresensiSemester = Presensi::where('siswa_id', $siswa->id)
                    ->where('semester_id', $semester_id)
                    ->pluck('mapel_id')
                    ->unique()
                    ->toArray();

                $mapelList = Mapel::whereIn('id', $mapelIdsPresensiSemester)->get();
            } else {
                $mapelList = collect(); // Jika tidak ada presensi, set kosong
            }
        }

        // Ambil nilai berdasarkan mata pelajaran dan semester
        $jadwalMapelIds = Presensi::where('siswa_id', $siswa->id)
            ->when($semester_id, function ($query) use ($semester_id) {
                $query->where('semester_id', $semester_id);
            })
            ->pluck('mapel_id')
            ->unique()
            ->toArray();

        $query = Nilai::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->whereIn('mapel_id', $jadwalMapelIds);

        if ($semester_id) {
            $query->where('semester_id', $semester_id);
        }

        $nilaiList = $query->get();

        // Menyusun data nilai
        $nilaiLabels = [];
        $nilaiRataRata = [];
        foreach ($nilaiList as $nilai) {
            $nilaiLabels[] = $nilai->mapel->nama_mapel;
            $nilaiRataRata[] = round($nilai->rata_rata, 2);
        }

        // Ambil daftar semester untuk filter
        $semesters = Semester::all();

        return view('nilai.index', compact('mapelList', 'nilaiList', 'nilaiLabels', 'nilaiRataRata', 'semesters', 'semester_id'));
    }

    public function show($id)
    {
        $siswa = Siswa::with(['user', 'kelas'])->findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::all();
        return view('siswa.update', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = $siswa->user;

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nisn' => 'required|unique:siswa,nisn,' . $siswa->id,
            'password' => 'nullable|confirmed|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Handle foto
        if ($request->hasFile('foto')) {
            if ($siswa->foto && file_exists(public_path('storage/foto/' . $siswa->foto))) {
                unlink(public_path('storage/foto/' . $siswa->foto));
            }
            $foto = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto', $fotoName);
        } else {
            $fotoName = $siswa->foto;
        }

        $siswa->update([
            'kelas_id' => $request->kelas_id,
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'status' => $request->status,
            'orangtua' => $request->orangtua,
            'foto' => $fotoName,
        ]);

        Alert::success('Berhasil', 'Data Siswa berhasil diperbarui!');
        return redirect()->route('siswa.index');
    }
}
