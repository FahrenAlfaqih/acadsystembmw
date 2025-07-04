<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminController,
    GuruController,
    KepalaSekolahController,
    PresensiController,
    ProfileController,
    SiswaController,
    KelasController,
    MapelController,
    JadwalMapelController,
    KenaikanKelasController,
    NilaiController,
    OrangTuaController,
    RaporController,
    SemesterController,
    TataUsahaController
};

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/

// Route halaman utama
Route::get('/', fn() => view('auth/login'));

Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return redirect("/dashboard/{$role}");
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('kepalasekolah', KepalaSekolahController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);

    Route::prefix('rapor')->group(function () {
        Route::get('/', [RaporController::class, 'index'])->name('rapor.index');
        Route::get('/preview/{kelas}', [RaporController::class, 'preview'])->name('rapor.preview');
        Route::get('/cetak/{kelas}', [RaporController::class, 'cetakPdf'])->name('rapor.cetakPdf');
        Route::get('/{kelasId}/siswa/{siswaId}/cetak', [RaporController::class, 'cetakPdfPerSiswa'])->name('rapor.cetak.per_siswa');
        Route::get('/{kelasId}/siswa/{siswaId}/cetak', [RaporController::class, 'cetakWordPerSiswa'])->name('rapor.cetakword.per_siswa');
    });
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/dashboard/guru', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/dashboard/guru/presensi/{kelas_id}/{mapel_id}/{semester_id}', [PresensiController::class, 'create'])->name('presensi.create');
    Route::get('/kenaikan-kelas', [KenaikanKelasController::class, 'formNaikKelas'])->name('kenaikan-kelas.index');
    Route::post('/kenaikan-kelas', [KenaikanKelasController::class, 'prosesNaikKelas'])->name('kenaikan-kelas.proses');
    Route::get('/nilai-guru', [GuruController::class, 'nilaiIndex'])->name('nilai.guru.index');
    Route::get('/presensi-guru', [GuruController::class, 'presensiIndex'])->name('presensi.guru.index');

    Route::get('/wali-kelas/siswa', [KenaikanKelasController::class, 'siswaByKelasGuru'])->name('wali-kelas-siswa.index');
    Route::get('/wali-kelas/siswa/nilai', [KenaikanKelasController::class, 'dataNilaiKelas'])->name('wali-kelas-siswaNilai.index');
    Route::get('/wali-kelas/siswa/presensi', [KenaikanKelasController::class, 'dataPresensiKelas'])->name('wali-kelas-siswaPresensi.index');

    Route::prefix('nilai')->group(function () {
        Route::get('/create/{kelas_id}/{mapel_id}/{semester_id}', [NilaiController::class, 'create'])->name('nilai.create');
        Route::post('/store/{kelas_id}/{mapel_id}/{semester_id}', [NilaiController::class, 'store'])->name('nilai.store');
        Route::get('/rekap/{kelas_id}/{semester_id}/{mapel_id}', [NilaiController::class, 'rekapKelas'])->name('rekap.nilai');
    });

    Route::prefix('presensi')->group(function () {
        Route::get('/', [PresensiController::class, 'index'])->name('presensi.index');
        Route::post('/{kelas_id}/{mapel_id}/{semester_id}', [PresensiController::class, 'store'])->name('presensi.store');
        Route::get('/{presensi}/edit', [PresensiController::class, 'edit'])->name('presensi.edit');
        Route::put('/{presensi}', [PresensiController::class, 'update'])->name('presensi.update');
        Route::delete('/{presensi}', [PresensiController::class, 'destroy'])->name('presensi.destroy');
        Route::get('/rekap/{kelas_id}/{semester_id}/{mapel_id}', [PresensiController::class, 'rekapKelas'])->name('rekap.presensi');
    });
});

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [SiswaController::class, 'dashboardSiswa'])->name('siswa.dashboard');
    Route::get('/presensi', [SiswaController::class, 'presensiIndex'])->name('presensi.index');
    Route::get('/nilai', [SiswaController::class, 'nilaiIndex'])->name('nilai.index');
    Route::get('/jadwal/siswa', [JadwalMapelController::class, 'indexJadwalSiswa'])->name('jadwal-siswa.index');
});

Route::middleware(['auth', 'role:orangtua'])->group(function () {
    Route::get('/dashboard/orangtua', [OrangTuaController::class, 'dashboardOrangTua'])->name('orangtua.dashboard');});

Route::middleware(['auth', 'role:kepalasekolah'])->group(function () {
    Route::get('/dashboard/kepalasekolah', [KepalaSekolahController::class, 'dashboard'])->name('dashboard.kepala');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'role:tatausaha'])->group(function () {
    Route::get('/dashboard/tatausaha', [TataUsahaController::class, 'dashboard'])->name('dashboard.tatausaha');

    Route::prefix('semester')->group(function () {
        Route::get('/', [SemesterController::class, 'index'])->name('semester.index');
        Route::get('/create', [SemesterController::class, 'create'])->name('semester.create');
        Route::post('/store', [SemesterController::class, 'store'])->name('semester.store');
        Route::get('/{semester}/edit', [SemesterController::class, 'edit'])->name('semester.edit');
        Route::put('/{semester}', [SemesterController::class, 'update'])->name('semester.update');
        Route::delete('/{semester}', [SemesterController::class, 'destroy'])->name('semester.destroy');
    });

    Route::prefix('kelas')->group(function () {
        // Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/store', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/{id}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/{id}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

    Route::prefix('mapel')->group(function () {
        // Route::get('/', [MapelController::class, 'index'])->name('mapel.index');
        Route::get('/create', [MapelController::class, 'create'])->name('mapel.create');
        Route::post('/store', [MapelController::class, 'store'])->name('mapel.store');
        Route::get('/{id}/edit', [MapelController::class, 'edit'])->name('mapel.edit');
        Route::put('/{id}', [MapelController::class, 'update'])->name('mapel.update');
        Route::delete('/{id}', [MapelController::class, 'destroy'])->name('mapel.destroy');
    });

    Route::prefix('jadwal')->group(function () {
        // Route::get('/', [JadwalMapelController::class, 'index'])->name('jadwal.index');
        Route::get('/create', [JadwalMapelController::class, 'create'])->name('jadwal.create');
        Route::post('/store', [JadwalMapelController::class, 'store'])->name('jadwal.store');
        Route::get('/{id}/edit', [JadwalMapelController::class, 'edit'])->name('jadwal.edit');
        Route::put('/{id}', [JadwalMapelController::class, 'update'])->name('jadwal.update');
        Route::delete('/{id}', [JadwalMapelController::class, 'destroy'])->name('jadwal.destroy');
    });
});

Route::middleware(['auth', 'role:kepalasekolah,tatausaha'])->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::get('/kepalasekolah', [KepalaSekolahController::class, 'index'])->name('kepalasekolah.index');

    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/mapel', [MapelController::class, 'index'])->name('mapel.index');
    Route::get('/jadwal', [JadwalMapelController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/filter', [JadwalMapelController::class, 'filterBySemester'])->name('jadwal.filter');
});
Route::middleware(['auth', 'role:kepalasekolah,tatausaha,admin'])->group(function () {
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
    Route::get('/kepalasekolah', [KepalaSekolahController::class, 'index'])->name('kepalasekolah.index');
});


require __DIR__ . '/auth.php';
