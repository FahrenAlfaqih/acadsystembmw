<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\KepalaSekolah;
use App\Models\Mapel;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;



class KepalaSekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kepalasekolah = KepalaSekolah::with('user')->get();
        return view('kepalasekolah.index', compact('kepalasekolah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kepalasekolah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'nip' => 'required|unique:kepala_sekolah,nip',

        ]);
        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $pathFoto = $foto->storeAs('foto_pengguna', $namaFile, 'public');
        }
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kepalasekolah',
        ]);

        // Simpan ke kepala sekolah
        KepalaSekolah::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'email' => $request->email,
            'status' => $request->status,
            'foto' => $pathFoto,
        ]);
        Alert::success('Berhasil', 'Data Kepala Sekolah berhasil ditambahkan!');
        return redirect()->route('kepalasekolah.index');
    }

    public function dashboard()
    {
        $sekolah = Sekolah::first();
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalMapel = Mapel::count();
        $totalKelas = Kelas::count();

        return view('dashboard.kepalasekolah', compact(
            'totalGuru',
            'totalSiswa',
            'totalMapel',
            'totalKelas',
            'sekolah'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show(KepalaSekolah $kepalaSekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KepalaSekolah $kepalaSekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KepalaSekolah $kepalaSekolah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KepalaSekolah $kepalaSekolah)
    {
        //
    }
}
