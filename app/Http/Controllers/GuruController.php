<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\JadwalMapel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Presensi;
use App\Models\Semester;
use App\Models\Siswa;
use RealRashid\SweetAlert\Facades\Alert;


class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with('user')->orderBy('nama', 'asc')->get();

        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'nip' => 'required|unique:guru,nip',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $pathFoto = $foto->storeAs('foto_pengguna', $namaFile, 'public');
        }

        // Simpan ke tabel users
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        // Simpan ke tabel guru dengan data minimal
        Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'tanggal_lahir' => null,
            'jenis_kelamin' => null,
            'alamat' => null,
            'no_telepon' => null,
            'email' => $request->email,
            'status' => 'Aktif',
            'foto' => $pathFoto,
        ]);

        Alert::success('Berhasil', 'Akun Guru berhasil ditambahkan. Lengkapi data di menu Edit sebagai Tata Usaha!');
        return redirect()->route('guru.index');
    }


    public function dashboard()
    {
        $jadwal = JadwalMapel::with(['kelas', 'mapel', 'semester'])
            ->where('guru_id', auth()->user()->guru->id)
            ->whereHas('semester', function ($query) {
                $query->where('is_aktif', 1);
            })
            ->get();

        return view('dashboard.guru', compact('jadwal'));
    }

    public function nilaiIndex(Request $request)
    {
        $user = Auth::user();
        $semester_id = $request->get('semester_id');
        $kelas_id = $request->get('kelas_id');
        $mapel_id = $request->get('mapel_id');

        $guru = Guru::where('user_id', $user->id)->first();

        $jadwalQuery = JadwalMapel::where('guru_id', $guru->id);
        if ($semester_id) $jadwalQuery->where('semester_id', $semester_id);
        $jadwalList = $jadwalQuery->get();

        $mapelList = Mapel::whereIn('id', $jadwalList->pluck('mapel_id'))->get();
        $kelasList = Kelas::whereIn('id', $jadwalList->pluck('kelas_id'))->get();

        $query = Nilai::with(['mapel', 'siswa'])
            ->whereIn('mapel_id', $jadwalList->pluck('mapel_id'))
            ->whereIn('kelas_id', $jadwalList->pluck('kelas_id'))
            ->where('guru_id', $guru->id);

        if ($semester_id) $query->where('semester_id', $semester_id);
        if ($mapel_id) $query->where('mapel_id', $mapel_id);
        if ($kelas_id) $query->where('kelas_id', $kelas_id);

        $nilaiList = $query->get()->sortBy(function ($item) {
            return $item->siswa->nama ?? '';
        })->values();
        $semesters = Semester::all();

        return view('nilai.index_guru', compact(
            'mapelList',
            'kelasList',
            'nilaiList',
            'semesters',
            'semester_id',
            'kelas_id',
            'mapel_id'
        ));
    }


    public function presensiIndex(Request $request)
    {
        $user = Auth::user();
        $guru = Guru::where('user_id', $user->id)->first();

        $semester_id = $request->get('semester_id');
        $kelas_id = $request->get('kelas_id');
        $mapel_id = $request->get('mapel_id');

        // Ambil jadwal mata pelajaran yang sesuai dengan guru yang sedang login
        $jadwalQuery = JadwalMapel::where('guru_id', $guru->id);
        if ($semester_id) $jadwalQuery->where('semester_id', $semester_id);
        $jadwalList = $jadwalQuery->get();

        $mapelList = Mapel::whereIn('id', $jadwalList->pluck('mapel_id'))->get();
        $kelasList = Kelas::whereIn('id', $jadwalList->pluck('kelas_id'))->get();
        $semesters = Semester::all();

        // Ambil data presensi yang sesuai dengan jadwal guru
        $presensiQuery = Presensi::with(['siswa', 'kelas', 'mapel'])
            ->whereIn('kelas_id', $jadwalList->pluck('kelas_id'))
            ->whereIn('mapel_id', $jadwalList->pluck('mapel_id'))
            ->where('guru_id', $guru->id); // Pastikan hanya presensi yang sesuai dengan guru yang ditampilkan

        $pertemuan_ke = $request->get('pertemuan_ke');
        if ($semester_id) $presensiQuery->where('semester_id', $semester_id);
        if ($kelas_id) $presensiQuery->where('kelas_id', $kelas_id);
        if ($mapel_id) $presensiQuery->where('mapel_id', $mapel_id);
        if ($pertemuan_ke) $presensiQuery->where('pertemuan_ke', $pertemuan_ke);

        $presensiList = $presensiQuery->get();

        $siswaList = Siswa::where('kelas_id', $kelas_id)
            ->orderBy('nama') 
            ->get();

        // Dapatkan semua pertemuan_ke yang tersedia
        $pertemuanList = $presensiList->pluck('pertemuan_ke')->unique()->sort()->values();

        // Buat array presensi per siswa per pertemuan
        $rekapPresensi = [];
        $kehadiranPersen = [];

        foreach ($siswaList as $siswa) {
            $rekapPresensi[$siswa->id] = [];

            $hadirCount = 0;
            $total = 0;

            foreach ($pertemuanList as $pertemuan) {
                $presensi = $presensiList->where('siswa_id', $siswa->id)
                    ->where('pertemuan_ke', $pertemuan)
                    ->first();

                $status = $presensi->status ?? '-';
                $rekapPresensi[$siswa->id][$pertemuan] = $status;

                if (in_array($status, ['Hadir'])) {
                    $hadirCount++;
                }

                if ($status !== '-') {
                    $total++;
                }
            }

            $kehadiranPersen[$siswa->id] = $total > 0 ? round(($hadirCount / $total) * 100) : 0;
        }

        return view('presensi.index_guru', compact(
            'mapelList',
            'kelasList',
            'semesters',
            'semester_id',
            'kelas_id',
            'mapel_id',
            'siswaList',
            'presensiList',
            'pertemuanList',
            'rekapPresensi',
            'kehadiranPersen'
        ));
    }

    public function show($id)
    {
        $guru = Guru::with('user', 'kelas')->findOrFail($id);
        return view('guru.show', compact('guru'));
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('guru.update', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $user = $guru->user;

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'required|unique:guru,nip,' . $guru->id,
            'password' => 'nullable|confirmed|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);


        if ($request->hasFile('foto')) {
            if ($guru->foto && file_exists(public_path('storage/foto/' . $guru->foto))) {
                unlink(public_path('storage/foto/' . $guru->foto));
            }
            $foto = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto', $fotoName);
        } else {
            $fotoName = $guru->foto;
        }

        // Update ke guru
        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'status' => $request->status,
            'foto' => $fotoName,
        ]);

        Alert::success('Berhasil', 'Data Guru berhasil diperbarui!');
        return redirect()->route('guru.index');
    }
}
