<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::all();
        return view('semester.index', compact('semesters'));
    }

    public function create()
    {
        return view('semester.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'tipe' => 'required|in:Ganjil,Genap',
        ]);

        // Jika checkbox is_aktif dicentang, nonaktifkan yang lain
        if ($request->has('is_aktif')) {
            Semester::where('is_aktif', true)->update(['is_aktif' => false]);
        }

        // Simpan data
        Semester::create([
            'nama' => $request->nama,
            'tahun_ajaran' => $request->tahun_ajaran,
            'tipe' => $request->tipe,
            'is_aktif' => $request->has('is_aktif'),
        ]);
        Alert::success('Berhasil', 'Data Semester berhasil disimpan!');
        return redirect()->route('semester.index');
    }

    public function edit(Semester $semester)
    {
        return view('semester.update', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $data = $request->all();
        $data['is_aktif'] = $request->has('is_aktif');

        if ($data['is_aktif']) {
            Semester::where('is_aktif', true)->where('id', '!=', $semester->id)->update(['is_aktif' => false]);
        }

        $request->validate([
            'nama' => 'required|string',
            'tahun_ajaran' => 'required|string',
            'tipe' => 'required|in:Ganjil,Genap',
        ]);

        $semester->update($data);
        Alert::success('Berhasil', 'Data Semester berhasil diperbarui!');

        return redirect()->route('semester.index');
    }


    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('semester.index')->with('success', 'Semester berhasil dihapus');
    }
}
