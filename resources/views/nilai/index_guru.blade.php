<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Nilai Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Filter Card --}}
        <div class="bg-white p-6 shadow-md rounded-lg mb-6">
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Filter Nilai</h3>

            <form method="GET" class="flex flex-wrap gap-3 sm:gap-4 items-end">

                {{-- Semester --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester_id"
                        class="text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach ($semesters as $sem)
                        <option value="{{ $sem->id }}" {{ $sem->id == $semester_id ? 'selected' : '' }}>
                            Semester {{ $loop->iteration }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Kelas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="kelas_id"
                        class="text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Semua Kelas --</option>
                        @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ $kelas->id == $kelas_id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Mapel --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <select name="mapel_id"
                        class="text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Semua Mapel --</option>
                        @foreach ($mapelList as $mapel)
                        <option value="{{ $mapel->id }}" {{ $mapel->id == $mapel_id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol Filter --}}
                <div>
                    <button type="submit"
                        class="mt-5 text-sm px-4 py-2 border border-blue-500 text-blue-600 rounded-lg shadow-sm transition hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Tabel Nilai --}}
        <div class="bg-white p-6 shadow-md rounded-lg">
            @if ($nilaiList->isEmpty())
            <p class="text-gray-500">Data nilai tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">Nama Siswa</th>
                            <th class="py-3 px-4 text-sm font-medium">Kelas</th>
                            <th class="py-3 px-4 text-sm font-medium">Mapel</th>
                            <th class="py-3 px-4 text-sm font-medium">Harian</th>
                            <th class="py-3 px-4 text-sm font-medium">UTS</th>
                            <th class="py-3 px-4 text-sm font-medium">UAS</th>
                            <th class="py-3 px-4 text-sm font-medium">Rata-rata</th>
                            <th class="py-3 px-4 text-sm font-medium">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilaiList as $nilai)
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $nilai->siswa->nama ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->kelas->nama_kelas ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_harian }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_uts }}</td>
                            <td class="py-3 px-4 text-sm">{{ $nilai->nilai_uas }}</td>
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