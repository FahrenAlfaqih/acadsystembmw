<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rapor {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .info-table,
        .nilai-table,
        .presensi-table,
        .absensi-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 5px;
        }

        .nilai-table th,
        .nilai-table td,
        .presensi-table th,
        .presensi-table td,
        .absensi-summary-table th,
        .absensi-summary-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        .nilai-table th,
        .presensi-table th,
        .absensi-summary-table th {
            background-color: #eee;
        }

        .section-title {
            margin-top: 30px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <h2>LAPORAN HASIL BELAJAR SISWA</h2>
    {{-- Tabel Informasi Siswa --}}
    <table class="info-table">
        <tr>
            <td>Nama Siswa</td>
            <td>: {{ $siswa->nama }}</td>
            <td>Kelas</td>
            <td>: {{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: {{ $siswa->nisn }}</td>
            <td>Semester</td>
            <td>: {{ $semester->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Rata-rata</td>
            <td>: {{ number_format($rataSiswa, 2) }}</td>
            <td>Ranking</td>
            <td>: {{ $ranking }}</td>
        </tr>
    </table>

    {{-- Tabel Nilai --}}
    <div class="section-title">A. Nilai Akademik</div>
    <table class="nilai-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>Nilai Harian</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Rata-rata</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @php
            $nilaiSiswa = $siswa->nilai()->where('kelas_id', $kelas->id)->get();
            @endphp
            @foreach ($nilaiSiswa as $index => $nilai)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td style="text-align: left;">{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ $nilai->nilai_harian }}</td>
                <td>{{ $nilai->nilai_uts }}</td>
                <td>{{ $nilai->nilai_uas }}</td>
                <td>{{ $nilai->rata_rata }}</td>
                <td>{{ $nilai->grade }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tabel Presensi --}}
    <!-- <div class="section-title">B. Presensi</div>
    <table class="presensi-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @php
            $presensiSiswa = $siswa->presensi()->where('kelas_id', $kelas->id)->get();
            @endphp
            @foreach ($presensiSiswa as $i => $presensi)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('d F Y') }}</td>
                <td>{{ $presensi->status_kehadiran }}</td>
            </tr>
            @endforeach
        </tbody>
    </table> -->

    {{-- Tabel ringkasan absensi --}}
    <div class="section-title">Ringkasan Absensi</div>
    @php
    $countAlpa = $presensiSiswa->where('status_kehadiran', 'Alpha')->count();
    $countSakit = $presensiSiswa->where('status_kehadiran', 'Sakit')->count();
    $countIzin = $presensiSiswa->where('status_kehadiran', 'Izin')->count();
    @endphp
    <table class="absensi-summary-table" style="width: 50%; margin-left: 0;">
        <thead>
            <tr>
                <th style="text-align: left;">Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left;">Alpa</td>
                <td>{{ $countAlpa }} Hari </td>
            </tr>
            <tr>
                <td style="text-align: left;">Sakit</td>
                <td>{{ $countSakit }} Hari</td>
            </tr>
            <tr>
                <td style="text-align: left;">Izin</td>
                <td>{{ $countIzin }} Hari</td>
            </tr>
        </tbody>
    </table>

</body>

</html>