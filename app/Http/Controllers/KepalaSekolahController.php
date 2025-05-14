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
            'tanggal_lahir' => null,
            'jenis_kelamin' => null,
            'alamat' => null,
            'no_telepon' => null,
            'email' =>  $request->email,
            'status' => 'Aktif',
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
    public function show($id)
    {
        $kepalasekolah = KepalaSekolah::findOrFail($id);
        return view('kepalasekolah.show', compact('kepalasekolah'));
    }

    public function edit($id)
    {
        $kepalasekolah = KepalaSekolah::findOrFail($id);
        return view('kepalasekolah.update', compact('kepalasekolah'));
    }

    public function update(Request $request, $id)
    {
        $kepala_sekolah = KepalaSekolah::findOrFail($id);
        $user = $kepala_sekolah->user;

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'required|unique:kepala_sekolah,nip,' . $kepala_sekolah->id,
            'password' => 'nullable|confirmed|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        if ($request->hasFile('foto')) {
            if ($kepala_sekolah->foto && file_exists(public_path('storage/foto/' . $kepala_sekolah->foto))) {
                unlink(public_path('storage/foto/' . $kepala_sekolah->foto));
            }
            $foto = $request->file('foto');
            $fotoName = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto', $fotoName);
        } else {
            $fotoName = $kepala_sekolah->foto;
        }

        $kepala_sekolah->update([
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
        Alert::success('Berhasil', 'Data Kepala Sekolah berhasil diperbarui!');

        return redirect()->route('kepalasekolah.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KepalaSekolah $kepalaSekolah)
    {
        //
    }
}
