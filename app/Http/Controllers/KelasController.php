<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->orderBy('tingkatan', 'asc')->get();
        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkatan' => 'required|string|max:255',
        ]);

        Kelas::create($request->all());

        Alert::success('Berhasil', 'Data kelas berhasil ditambahkan!');

        return redirect()->route('kelas.index');
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $guru = Guru::all();
        return view('kelas.update', compact('kelas', 'guru'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkatan' => 'required|string|max:255',
        ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->update($request->only(['nama_kelas', 'tingkatan']));

        if ($request->filled('wali_kelas_id')) {
            if ($kelas->wali_kelas_id) {
                Guru::where('id', $kelas->wali_kelas_id)->update([
                    'is_wali_kelas' => false,
                    'kelas_id' => null,
                ]);
            }

            $kelas->update(['wali_kelas_id' => $request->wali_kelas_id]);

            Guru::where('id', $request->wali_kelas_id)->update([
                'is_wali_kelas' => true,
                'kelas_id' => $kelas->id,
            ]);
        }
        Alert::success('Berhasil', 'Data kelas berhasil diperbarui!');
        return redirect()->route('kelas.index');
    }



    public function destroy(Kelas $kelas)
    {
        $kelas->delete();
        return redirect()->route('kelas.index');
    }
}
