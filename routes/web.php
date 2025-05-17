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

// Route yang memerlukan autentikasi
Route::middleware(['auth'])->group(function () {

    // Redirect dashboard sesuai role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return redirect("/dashboard/{$role}");
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard per role
    Route::middleware('role:orangtua')->get('/dashboard/orangtua', fn() => view('dashboard.orangtua'));
    Route::middleware('role:guru')->get('/dashboard/guru', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::middleware('role:admin')->get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::middleware('role:kepalasekolah')->get('/dashboard/kepalasekolah', [KepalaSekolahController::class, 'dashboard'])->name('dashboard.kepala');
    Route::middleware('role:guru')->get('/dashboard/guru/presensi/{kelas_id}/{mapel_id}/{semester_id}', [PresensiController::class, 'create'])->name('presensi.create');

    Route::middleware('role:guru')->get('/kenaikan-kelas', [KenaikanKelasController::class, 'formNaikKelas'])->name('kenaikan-kelas.index');
    Route::middleware('role:guru')->post('/kenaikan-kelas', [KenaikanKelasController::class, 'prosesNaikKelas'])->name('kenaikan-kelas.proses');

    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::get('/guru/create', [GuruController::class, 'create'])->name('guru.create');

    Route::get('/guru/{id}', [GuruController::class, 'show'])->name('guru.show');
    Route::get('/siswa/{id}', [SiswaController::class, 'show'])->name('siswa.show');
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('kepalasekolah', KepalaSekolahController::class);


    Route::prefix('presensi')->group(function () {
        Route::get('/', [PresensiController::class, 'index'])->name('presensi.index');
        Route::post('/{kelas_id}/{mapel_id}/{semester_id}', [PresensiController::class, 'store'])->name('presensi.store');
        Route::get('/{presensi}/edit', [PresensiController::class, 'edit'])->name('presensi.edit');
        Route::put('/{presensi}', [PresensiController::class, 'update'])->name('presensi.update');
        Route::delete('/{presensi}', [PresensiController::class, 'destroy'])->name('presensi.destroy');
        Route::get('/rekap/{kelas_id}/{semester_id}/{mapel_id}', [PresensiController::class, 'rekapKelas'])->name('rekap.presensi');
    });

    Route::prefix('nilai')->group(function () {
        Route::get('/create/{kelas_id}/{mapel_id}/{semester_id}', [NilaiController::class, 'create'])->name('nilai.create');
        Route::post('/store/{kelas_id}/{mapel_id}/{semester_id}', [NilaiController::class, 'store'])->name('nilai.store');
        Route::get('/rekap/{kelas_id}/{semester_id}/{mapel_id}', [NilaiController::class, 'rekapKelas'])->name('rekap.nilai');
    });
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/nilai-guru', [GuruController::class, 'nilaiIndex'])->name('nilai.guru.index');
    Route::get('/presensi-guru', [GuruController::class, 'presensiIndex'])->name('presensi.guru.index');
});


Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [SiswaController::class, 'dashboardSiswa'])->name('siswa.dashboard');
    Route::get('/presensi', [SiswaController::class, 'presensiIndex'])->name('presensi.index');
    Route::get('/nilai', [SiswaController::class, 'nilaiIndex'])->name('nilai.index');
});

Route::middleware(['auth', 'role:tatausaha'])->group(function () {
    Route::get('/dashboard/tatausaha', [TataUsahaController::class, 'dashboard'])->name('dashboard.tatausaha');
    Route::get('/jadwal/filter', [JadwalMapelController::class, 'filterBySemester'])->name('jadwal.filter');
    Route::resource('kelas', KelasController::class)->except(['show']);
    Route::resource('mapel', MapelController::class)->except(['show']);
    Route::resource('jadwal', JadwalMapelController::class)->except(['show']);
    Route::resource('semester', SemesterController::class);

    Route::get('/rapor', [RaporController::class, 'index'])->name('rapor.index');
    Route::get('/rapor/preview/{kelas}', [RaporController::class, 'preview'])->name('rapor.preview');
    Route::get('/rapor/cetak/{kelas}', [RaporController::class, 'cetakPdf'])->name('rapor.cetakPdf');
    Route::get('/rapor/{kelasId}/siswa/{siswaId}/cetak', [RaporController::class, 'cetakPdfPerSiswa'])->name('rapor.cetak.per_siswa');

});

require __DIR__ . '/auth.php';
