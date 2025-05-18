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
                        class="text-sm px-3 py-1.5  border transition rounded-lg shadow-sm
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>