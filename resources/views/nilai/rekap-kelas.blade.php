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

    <div class="py-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 font-semibold text-center">Nama Siswa</th>
                        <th class="px-4 py-2 font-semibold text-center">Nilai Harian</th>
                        <th class="px-4 py-2 font-semibold text-center">Nilai UTS</th>
                        <th class="px-4 py-2 font-semibold text-center">Nilai UAS</th>
                        <th class="px-4 py-2 font-semibold text-center">Rata-rata</th>
                        <th class="px-4 py-2 font-semibold text-center">Grade</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($siswaList as $siswa)
                    @php
                    $nilai = $nilaiData->firstWhere('siswa_id', $siswa->id);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $siswa->nama }}</td>
                        <td class="px-4 py-2 text-center">{{ $nilai->nilai_harian ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $nilai->nilai_uts ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">{{ $nilai->nilai_uas ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            @if($nilai && is_numeric($nilai->rata_rata))
                            {{ number_format($nilai->rata_rata, 2) }}
                            @else
                            -
                            @endif
                        </td>

                        <td class="px-4 py-2 text-center">
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
</x-app-layout>