<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::all();
        return view('mapel.index', compact('mapels'));
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:255|unique:mapels',
            'nama_mapel' => 'required|string|max:255',
        ]);

        Mapel::create($request->all());
        Alert::success('Berhasil', 'Data Mata Pelajaran berhasil ditambahkan!');

        return redirect()->route('mapel.index');
    }

    public function edit(Mapel $mapel)
    {
        return view('mapel.update', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $request->validate([
            'kode_mapel' => 'required|string|max:255|unique:mapels,kode_mapel,' . $mapel->id,
            'nama_mapel' => 'required|string|max:255',
        ]);

        $mapel->update($request->all());
        Alert::success('Berhasil', 'Data Mata Pelajaran berhasil diperbarui!');

        return redirect()->route('mapel.index');
    }

    public function destroy(Mapel $mapel)
    {
        $mapel->delete();
        return redirect()->route('mapel.index');
    }
}
