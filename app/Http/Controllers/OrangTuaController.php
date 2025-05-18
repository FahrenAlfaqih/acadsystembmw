<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\JadwalMapel;
use App\Models\Presensi;
use App\Models\Nilai;

class OrangTuaController extends Controller
{

    public function dashboardOrangTua()
    {
        $user = Auth::user();

        $siswa = Siswa::where('orangtua', $user->id)->first();
        if (!$siswa) {
            return view('dashboard.orangtua')->with('message', 'Data siswa tidak ditemukan.');
        }

        $kelas_id = $siswa->kelas_id;

        $jadwalMapelIds = JadwalMapel::where('kelas_id', $kelas_id)
            ->pluck('mapel_id')
            ->toArray();

        $mapelList = Mapel::whereIn('id', $jadwalMapelIds)->get();
        

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

        return view('dashboard.orangtua', compact(
            'siswa',
            'mapelList',
            'pertemuanList',
            'presensiMap',
            'kehadiranPersen',
            'nilaiList',
            'nilaiLabels',
            'nilaiRataRata'
        ));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OrangTua $orangTua)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrangTua $orangTua)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrangTua $orangTua)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrangTua $orangTua)
    {
        //
    }
}
