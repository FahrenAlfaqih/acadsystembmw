<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rekap Presensi: {{ $mapel->nama_mapel }}
                — {{ $semester->tipe }} {{ $semester->tahun_ajaran }}
                (Kelas {{ $kelas->nama_kelas }})
            </h2>
        </div>

    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    Rekap Kehadiran Siswa
                </h3>
            </div>

            @if($siswaList->isEmpty())
            <p class="mt-2 text-gray-500">Data siswa tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">Nama Siswa</th>
                            @foreach ($presensiData as $pertemuan => $presensi)
                            <th class="py-3 px-4 text-sm font-medium text-center">P{{ $pertemuan }}</th>
                            @endforeach
                            <th class="py-3 px-4 text-sm font-medium text-center">Total Hadir (%)</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswaList as $siswa)
                        @php
                        $totalHadir = 0;
                        $totalPertemuan = count($presensiData);
                        @endphp
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $siswa->nama }}</td>
                            @foreach ($presensiData as $pertemuan => $presensi)
                            @php
                            $presensiSiswa = $presensi->firstWhere('siswa_id', $siswa->id);
                            if ($presensiSiswa && $presensiSiswa->status_kehadiran === 'Hadir') {
                            $totalHadir++;
                            }
                            @endphp
                            <td class="py-3 px-4 text-sm text-center">
                                @if($presensiSiswa)
                                @php
                                $status = $presensiSiswa->status_kehadiran;
                                @endphp
                                <span class="inline-block px-2 py-1 rounded text-white text-xs
                    {{ $status == 'Hadir' ? 'bg-green-500' : ($status == 'Izin' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                    {{ $status }}
                                </span>
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            @endforeach

                            <!-- Kolom Total Kehadiran -->
                            <td class="py-3 px-4 text-sm text-center font-semibold text-green-700">
                                @php
                                $persenHadir = $totalPertemuan > 0 ? ($totalHadir / $totalPertemuan) * 100 : 0;
                                @endphp
                                {{ number_format($persenHadir, 2) }}%
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>