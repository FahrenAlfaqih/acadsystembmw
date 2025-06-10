<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Nilai Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    Nilai Siswa
                </h3>

                <!-- Tombol filter semester ukuran kecil dengan penomoran otomatis -->
                <div class="flex space-x-2 mb-4">
                    @foreach ($semesters as $semester)
                    <a href="{{ route('nilai.index', ['semester_id' => $semester->id]) }}"
                        class="text-sm px-3 py-1.5 border transition rounded-lg shadow-sm
        {{ $semester->id == $semester_id ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-blue-100' }}">
                        Semester {{ $loop->iteration }}
                    </a>
                    @endforeach
                </div>

            </div>

            @if($nilaiList->isEmpty())
            <p class="mt-2 text-gray-500">Data nilai tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                    <thead>
                        <tr class="bg-white text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">Mata Pelajaran</th>
                            <th class="py-3 px-4 text-sm font-medium">Nilai Harian</th>
                            <th class="py-3 px-4 text-sm font-medium">UTS</th>
                            <th class="py-3 px-4 text-sm font-medium">UAS</th>
                            <th class="py-3 px-4 text-sm font-medium">Rata-rata</th>
                            <th class="py-3 px-4 text-sm font-medium">Grade</th>
                            <th class="py-3 px-4 text-sm font-medium">Aksi</th> <!-- Kolom aksi -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapelList as $mapel)
                        @php
                        $nilai = $nilaiList->firstWhere('mapel_id', $mapel->id);
                        @endphp
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $mapel->nama_mapel }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_harian ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_uts ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_uas ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm font-semibold text-blue-600">
                                {{ isset($nilai->rata_rata) ? number_format($nilai->rata_rata, 2) : '-' }}
                            </td>
                            <td class="py-3 px-4 text-sm font-bold text-white">
                                @if ($nilai)
                                <span class="@switch($nilai->grade)
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
                            <td class="py-3 px-4 text-sm">
                                <!-- Tombol Detail -->
                                <button type="button" class="px-4 py-2 bg-blue-500 text-white rounded-md"
                                    onclick="toggleDetail({{ $mapel->id }})">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <!-- Breakdown Nilai Harian -->
                        <tr id="detail-{{ $mapel->id }}" class="hidden">
                            <td colspan="7" class="py-4 px-6 bg-gray-100 border-t border-gray-300">
                                <div class="bg-white shadow-sm rounded-lg p-4">
                                    <h4 class="font-semibold text-lg mb-4 text-gray-800">Breakdown Nilai Harian</h4>

                                    <ul class="list-disc pl-6 space-y-2">
                                        <li class="text-sm text-gray-700"><strong>Nilai Ulangan Harian:</strong> <span class="font-semibold">{{ $nilai->nilai_ulangan_harian ?? '-' }}</span></li>
                                        <li class="text-sm text-gray-700"><strong>Nilai Quiz:</strong> <span class="font-semibold">{{ $nilai->nilai_quiz ?? '-' }}</span></li>
                                        <li class="text-sm text-gray-700"><strong>Nilai Tugas:</strong> <span class="font-semibold">{{ $nilai->nilai_tugas ?? '-' }}</span></li>
                                    </ul>

                                    <!-- Menambahkan rules perhitungan nilai harian -->
                                    <div class="mt-4 p-4 bg-gray-50 border-l-4 border-blue-500 text-gray-700 text-sm">
                                        <p><strong>Perhitungan Nilai Harian:</strong></p>
                                        <p><code class="font-mono">Nilai Harian = (Nilai Ulangan Harian * 0.4) + (Nilai Quiz * 0.3) + (Nilai Tugas * 0.3)</code></p>
                                    </div>

                                    <!-- Menambahkan rules perhitungan rata-rata akhir -->
                                    <div class="mt-4 p-4 bg-gray-50 border-l-4 border-blue-500 text-gray-700 text-sm">
                                        <p><strong>Perhitungan Rata-rata Akhir:</strong></p>
                                        <p><code class="font-mono">Rata-rata = (Nilai Harian + Nilai UTS + Nilai UAS) / 3</code></p>
                                    </div>
                                </div>
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
        function toggleDetail(mapelId) {
            const detailRow = document.getElementById('detail-' + mapelId);
            detailRow.classList.toggle('hidden');
        }
    </script>
    @endpush
</x-app-layout>