<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Presensi Siswa Kelas {{ $kelas->nama_kelas }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 shadow-md rounded-lg mb-6">
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Filter Nilai</h3>
            {{-- Form Filter Mapel --}}
            <form method="GET" class="mb-6 max-w-sm">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Berdasarkan Mapel</label>
                <select name="mapel_id"
                    onchange="this.form.submit()"
                    class="w-full text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm">
                    <option value="">-- Semua Mapel --</option>
                    @foreach ($mapel as $m)
                    <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mapel }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">


            <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Presensi Siswa</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0">
                    <thead class="bg-gray-200 text-gray-600">
                        <tr>
                            <th class="py-3 px-4 text-sm font-medium">No</th>
                            <th class="py-3 px-4 text-sm font-medium">Nama</th>
                            <th class="py-3 px-4 text-sm font-medium">NISN</th>
                            <th class="py-3 px-4 text-sm font-medium">Jumlah Hadir</th>
                            <th class="py-3 px-4 text-sm font-medium">Jumlah Izin</th>
                            <th class="py-3 px-4 text-sm font-medium">Jumlah Sakit</th>
                            <th class="py-3 px-4 text-sm font-medium">Jumlah Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $key => $s)
                        @php
                        $hadir = $s->presensi->where('status_kehadiran', 'Hadir')->count();
                        $izin = $s->presensi->where('status_kehadiran', 'Izin')->count();
                        $sakit = $s->presensi->where('status_kehadiran', 'Sakit')->count();
                        $alpha = $s->presensi->where('status_kehadiran', 'Alpha')->count();
                        @endphp
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $key + 1 }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->nama }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->nisn }}</td>
                            <td class="py-3 px-4 text-sm">{{ $hadir }}</td>
                            <td class="py-3 px-4 text-sm">{{ $izin }}</td>
                            <td class="py-3 px-4 text-sm">{{ $sakit }}</td>
                            <td class="py-3 px-4 text-sm">{{ $alpha }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">Data presensi tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>