<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Presensi Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    Daftar Presensi Siswa
                </h3>

                <!-- Tombol filter semester ukuran kecil dengan penomoran otomatis -->
                <div class="flex space-x-2 mb-4">
                    @foreach ($semesters as $semester)
                    <a href="{{ route('presensi.index', ['semester_id' => $semester->id]) }}"
                        class="text-sm px-3 py-1.5  border transition rounded-lg shadow-sm
        {{ $semester->id == $semester_id ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-blue-100' }}">
                        Semester {{ $loop->iteration }}
                    </a>
                    @endforeach
                </div>

            </div>

            @if($mapelList->isEmpty())
            <p class="mt-2 text-gray-500">Data presensi tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                    <thead>
                        <tr class="bg-white text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">Mata Pelajaran</th>
                            @foreach ($pertemuanList as $pertemuan)
                            <th class="py-3 px-4 text-sm font-medium text-center">
                                P{{ $pertemuan }}<br>
                                <span class="text-xs text-gray-500">
                                    ({{ \Carbon\Carbon::parse($tanggalPertemuan[$pertemuan])->format('d M Y') }})
                                </span>
                            </th>
                            @endforeach

                            <th class="py-3 px-4 text-sm font-medium text-center">Persentase Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mapelList as $mapel)
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $mapel->nama_mapel }}</td>
                            @foreach ($pertemuanList as $pertemuan)
                            <td class="py-3 px-4 text-center text-sm">
                                {{ $presensiMap[$mapel->id][$pertemuan] ?? '-' }}
                            </td>
                            @endforeach
                            <td class="py-3 px-4 text-center text-sm font-semibold text-blue-600">
                                {{ $kehadiranPersen[$mapel->id] }}%
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