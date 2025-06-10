<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Rekap Nilai: {{ $mapel->nama_mapel }}
                — {{ $semester->tipe }} {{ $semester->tahun_ajaran }}
                (Kelas {{ $kelas->nama_kelas }})
            </h2>
        </div>

    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('guru.dashboard') }}"
            class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition mb-3">
            Kembali ke dashboard
        </a>
        <div class="bg-white p-6 shadow-md rounded-lg overflow-x-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800 mb-4"> Nilai Siswa</h3>
                <div class="mb-4">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari siswa..."
                        class="w-full sm:w-64 h-10 px-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                    <thead>
                        <tr class="bg-white text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">Nama Siswa</th>
                            <th class="py-3 px-4 text-sm font-medium"> Ulangan Harian</th>
                            <th class="py-3 px-4 text-sm font-medium"> Quiz</th>
                            <th class="py-3 px-4 text-sm font-medium"> Tugas</th>
                            <th class="py-3 px-4 text-sm font-medium"> Total Nilai Harian</th>
                            <th class="py-3 px-4 text-sm font-medium"> UTS</th>
                            <th class="py-3 px-4 text-sm font-medium"> UAS</th>
                            <th class="py-3 px-4 text-sm font-medium">Rata-rata</th>
                            <th class="py-3 px-4 text-sm font-medium">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswaList as $siswa)
                        @php
                        $nilai = $nilaiData->firstWhere('siswa_id', $siswa->id);
                        @endphp
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $siswa->nama }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_ulangan_harian }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_quiz }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_tugas }}</td>
                            <td class=" py-3 px-4 text-sm font-semibold text-blue-600">{{ $nilai->nilai_harian ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_uts ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_uas ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm font-semibold text-blue-600">
                                @if($nilai && is_numeric($nilai->rata_rata))
                                {{ number_format($nilai->rata_rata, 2) }}
                                @else
                                -
                                @endif
                            </td>

                            <td class="px-4 py-2 text-sm">
                                @if ($nilai && $nilai->grade)
                                <span class="font-bold text-white
                                        @switch($nilai->grade)
                                            @case('A') bg-green-500 @break
                                             @case('AB') bg-green-700 @break
                                            @case('B') bg-blue-500 @break
                                            @case('C') bg-yellow-500 text-gray-800 @break
                                            @case('D') bg-orange-500 @break
                                            @case('E') bg-red-500 @break
                                            @default bg-gray-400
                                        @endswitch px-3 py-1 rounded-full text-xs inline-block">
                                    {{ $nilai->grade }}
                                </span>
                                @else
                                <span class="bg-gray-400 px-2 py-1 rounded">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                Tidak ada data nilai tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
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