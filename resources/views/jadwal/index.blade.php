<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jadwal Mata Pelajaran
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Filter Card --}}
        @if($semesterAktif)
        <div class="bg-white p-6 shadow-md rounded-lg mb-6">
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Filter Jadwal</h3>
            <form action="{{ route('jadwal.filter') }}" method="GET" class="flex flex-wrap gap-3 sm:gap-4 items-end">
                <div>
                    <label for="semester_id" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester_id" id="semester_id"
                        class="text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($semesters ?? \App\Models\Semester::all() as $semester)
                        <option value="{{ $semester->id }}" {{ (isset($semesterDipilih) && $semesterDipilih->id == $semester->id) ? 'selected' : '' }}>
                            {{ $semester->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="mt-5 text-sm px-4 py-2 border border-blue-500 text-blue-600 rounded-lg shadow-sm transition hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <i class="fas fa-filter mr-1"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
        @endif

        {{-- Tabel Jadwal --}}
        <div class="bg-white p-6 shadow-md rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    Daftar Jadwal Pelajaran
                </h3>
                <a href="{{ route('jadwal.create') }}"
                    class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                    Tambah Jadwal
                </a>
            </div>

            @if($jadwalPerSemester->isEmpty())
            <p class="text-gray-500">Data jadwal tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                @foreach($jadwalPerSemester as $semester => $jadwals)
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-2">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">No</th>
                            <th class="py-3 px-4 text-sm font-medium">Kelas</th>
                            <th class="py-3 px-4 text-sm font-medium">Mata Pelajaran</th>
                            <th class="py-3 px-4 text-sm font-medium">Guru</th>
                            <th class="py-3 px-4 text-sm font-medium">Hari</th>
                            <th class="py-3 px-4 text-sm font-medium">Jam Mulai</th>
                            <th class="py-3 px-4 text-sm font-medium">Jam Selesai</th>
                            <th class="py-3 px-4 text-sm font-medium text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jadwals as $index => $item)
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 text-sm">{{ $item->kelas->nama_kelas }}</td>
                            <td class="py-3 px-4 text-sm">{{ $item->mapel->nama_mapel }}</td>
                            <td class="py-3 px-4 text-sm">{{ $item->guru->nama }}</td>
                            <td class="py-3 px-4 text-sm">{{ $item->hari }}</td>
                            <td class="py-3 px-4 text-sm">{{ $item->jam_mulai }}</td>
                            <td class="py-3 px-4 text-sm">{{ $item->jam_selesai }}</td>
                            <td class="py-3 px-4 text-sm text-center space-x-2">
                                <a href="{{ route('jadwal.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('jadwal.destroy', $item->id) }}" method="POST"
                                    class="inline-block"
                                    onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endforeach
            </div>
            @endif
        </div>

    </div>
</x-app-layout>