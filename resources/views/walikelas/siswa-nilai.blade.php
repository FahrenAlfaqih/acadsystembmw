<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Nilai Siswa {{$kelas->nama_kelas}}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded-2xl shadow">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <h3 class="font-semibold text-lg text-gray-800">Nilai Siswa</h3>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <form method="GET">
                        <select name="sort"
                            onchange="this.form.submit()"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-2xl shadow-sm bg-gray-300 font-medium text-black">
                            <option value="">-- Urutan --</option>
                            <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama (A-Z)</option>
                            <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama (Z-A)</option>
                            <option value="ranking_asc" {{ request('sort') == 'ranking_asc' ? 'selected' : '' }}>Ranking Tertinggi</option>
                            <option value="ranking_desc" {{ request('sort') == 'ranking_desc' ? 'selected' : '' }}>Ranking Terendah</option>
                        </select>

                    </form>

                    <!-- Search Input -->
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari siswa..."
                        class="w-full sm:w-64 h-10 px-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0">
                    <thead class="bg-white text-gray-600">
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
                            <td class="py-3 px-4 text-sm font-semibold text-blue-600">{{ $s->rata_rata }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->ranking }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-4 text-center text-gray-500">Data siswa tidak tersedia.</td>
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