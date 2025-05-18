<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Rapor Kelas {{ $kelas->nama_kelas }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .info-table,
        .nilai-table,
        .presensi-table,
        .absensi-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .info-table td {
            padding: 5px 8px;
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

        /* Mata Pelajaran rata kiri */
        .nilai-table td:first-child {
            text-align: left;
        }

        .section-title {
            margin-top: 30px;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 14px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <h2>Rapor Kelas {{ $kelas->nama_kelas }}</h2>

    @foreach ($siswa as $s)
    {{-- Tabel info siswa dan semester --}}
    <table class="info-table">
        <tr>
            <td>Nama Siswa</td>
            <td>: {{ $s->nama }}</td>
            <td>Kelas</td>
            <td>: {{ $kelas->nama_kelas }}</td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: {{ $s->nisn }}</td>
            <td>Semester</td>
            <td>: {{ $semester->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Rata-rata</td>
            <td>: {{ number_format($s->rata_rata, 2) }}</td>
            <td>Ranking</td>
            <td>: {{ $s->ranking }}</td>
        </tr>

    </table>

    {{-- Tabel nilai --}}
    <div class="section-title">Nilai</div>
    <table class="nilai-table">
        <thead>
            <tr>
                <th>Mata Pelajaran</th>
                <th>Nilai Harian</th>
                <th>Nilai UTS</th>
                <th>Nilai UAS</th>
                <th>Rata-rata</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @php
            $nilaiSiswa = $s->nilai()->where('kelas_id', $kelas->id)->get();
            @endphp
            @foreach ($nilaiSiswa as $nilai)
            <tr>
                <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                <td>{{ $nilai->nilai_harian }}</td>
                <td>{{ $nilai->nilai_uts }}</td>
                <td>{{ $nilai->nilai_uas }}</td>
                <td>{{ $nilai->rata_rata }}</td>
                <td>{{ $nilai->grade }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tabel presensi --}}
    <!-- <div class="section-title">Presensi</div>
    <table class="presensi-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @php
            $presensiSiswa = $s->presensi()->where('kelas_id', $kelas->id)->get();
            @endphp
            @foreach ($presensiSiswa as $presensi)
            <tr>
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


    <div class="page-break"></div>
    @endforeach
</body>

</html>