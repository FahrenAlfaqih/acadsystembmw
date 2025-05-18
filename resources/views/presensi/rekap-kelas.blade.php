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

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 ">
        <a href="{{ route('guru.dashboard') }}"
            class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition mb-3">
            Kembali ke dashboard
        </a>
        <div class="bg-white p-6 shadow-md rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    Rekap Kehadiran Siswa
                </h3>
                <div class="mb-4">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari siswa..."
                        class="w-full sm:w-64 h-10 px-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
            </div>

            @if($siswaList->isEmpty())
            <p class="mt-2 text-gray-500">Data siswa tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                    <thead>
                        <tr class="bg-white text-gray-600">
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
                                {{ $status }}
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            @endforeach

                            <!-- Kolom Total Kehadiran -->
                            <td class="py-3 px-4 text-sm text-center font-semibold text-blue-600">
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
    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const tableRows = document.querySelectorAll("tbody tr");

            searchInput.addEventListener("keyup", function() {
                const searchTerm = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    row.style.display = rowText.includes(searchTerm) ? "" : "none";
                });
            });
        });
    </script>
    @endpush

</x-app-layout>