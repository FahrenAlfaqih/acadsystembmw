<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rapor {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 30px;
        }

        h1,
        h2,
        h3 {
            text-align: center;
            margin: 0;
        }

        .line {
            border-top: 2px solid #000;
            margin: 10px 0 20px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        .info-table td {
            border: none;
            padding: 4px 8px;
        }

        .signature-table td {
            text-align: center;
            height: 70px;
        }

        .no-border {
            border: none;
        }
    </style>
</head>

<body>

    <h2>RAPOR PESERTA DIDIK</h2>
    <h3>KURIKULUM MERDEKA</h3>
    <h3>SMA BINA MITRA WAHANA</h3>
    <h3>{{ $semester->nama }} Tahun Pelajaran {{ $semester->tahun_ajaran }}</h3>
    <div class="line"></div>


    {{-- I. Identitas Peserta Didik --}}
    <div class="section-title">I. Identitas Peserta Didik</div>
    <table>
        <thead>
            <tr>
                <th>Komponen</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nama Peserta Didik</td>
                <td>{{ $siswa->nama }}</td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>{{ $siswa->nisn }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>{{ $kelas->nama_kelas }}</td>
            </tr>
            <tr>
                <td>Sekolah</td>
                <td>SMA Bina Mitra Wahana</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>{{ $semester->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tahun Pelajaran</td>
                <td>2024/2025</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>{{ $siswa->alamat ?? '-' }}</td>
            </tr>
        </tbody>
    </table>


    {{-- II. Daftar Nilai dan Capaian Kompetensi --}}
    <div class="section-title">II. Daftar Nilai dan Capaian Kompetensi</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai Akhir</th>
                <th>Deskripsi Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $nilaiSiswa = $siswa->nilai()->where('kelas_id', $kelas->id)->get();
            @endphp
            @foreach ($nilaiSiswa as $index => $nilai)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                <td style="text-align: center;">{{ $nilai->rata_rata }}</td>
                <td>{{ $nilai->deskripsi ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- III. Kegiatan Ekstrakurikuler --}}
    <div class="section-title">III. Kegiatan Ekstrakurikuler</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kegiatan Ekstrakurikuler</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>2</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>3</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>


    {{-- IV. Ketidakhadiran --}}
    <div class="section-title">IV. Ketidakhadiran</div>
    @php
    $countAlpa = $presensi->where('status_kehadiran', 'Alpha')->count();
    $countSakit = $presensi->where('status_kehadiran', 'Sakit')->count();
    $countIzin = $presensi->where('status_kehadiran', 'Izin')->count();
    @endphp
    <table>
        <thead>
            <tr>
                <th>Keterangan</th>
                <th>Jumlah Hari</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sakit</td>
                <td>{{ $countSakit }} Hari</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td>{{ $countIzin }} Hari</td>
            </tr>
            <tr>
                <td>Tanpa Keterangan (Alpha)</td>
                <td>{{ $countAlpa }} Hari</td>
            </tr>
        </tbody>
    </table>

    {{-- V. Catatan Guru --}}
    <div class="section-title">V. Catatan Guru</div>
    <p style="min-height: 60px;">&nbsp;</p>

    {{-- VI. Tanda Tangan --}}
    <div class="section-title">VI. Tanda Tangan</div>
    <table class="signature-table">
        <tr>
            <td>Orang Tua / Wali</td>
            <td>Kepala Sekolah</td>
            <td>Wali Kelas</td>
        </tr>
        <tr>
            <td><br><br><br><br>(...........................................)</td>
            <td><br><br><br><br>(...........................................)</td>
            <td><br><br><br><br>(...........................................)</td>
        </tr>
    </table>

</body>

</html>