<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Siswa Kelas {{ $kelas->nama_kelas ?? '' }} </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg mb-6">
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Filter Nilai</h3>
            <form method="GET" class="mb-6 max-w-sm">
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan Berdasarkan</label>
                <select name="sort"
                    onchange="this.form.submit()"
                    class="w-full text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih --</option>
                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                    <option value="ranking_asc" {{ request('sort') == 'ranking_asc' ? 'selected' : '' }}>Ranking Tertinggi</option>
                    <option value="ranking_desc" {{ request('sort') == 'ranking_desc' ? 'selected' : '' }}>Ranking Terendah</option>
                </select>
            </form>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">



            <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Siswa</h3>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0">
                    <thead class="bg-gray-200 text-gray-600">
                        <tr>
                            <th class="py-3 px-4 text-sm font-medium">No</th>
                            <th class="py-3 px-4 text-sm font-medium">Nama</th>
                            <th class="py-3 px-4 text-sm font-medium">NISN</th>
                            <th class="py-3 px-4 text-sm font-medium">Rata-rata Nilai</th>
                            <th class="py-3 px-4 text-sm font-medium">Ranking</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $key => $s)
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $key + 1 }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->nama }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->nisn }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->rata_rata }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->ranking }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="border px-4 py-4 text-center text-gray-500">Data siswa tidak tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>