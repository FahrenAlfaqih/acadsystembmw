<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Presensi Siswa {{$kelas->nama_kelas}}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded-2xl shadow">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4">
                <h3 class="font-semibold text-lg text-gray-800">Nilai Siswa</h3>
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <form method="GET">
                        <select name="mapel_id"
                            onchange="this.form.submit()"
                            class="w-full text-sm px-3 py-2 border border-gray-300 rounded-2xl shadow-sm bg-gray-300 font-medium text-black">
                            <option value="">-- Mata Pelajaran --</option>
                            @foreach ($mapel as $m)
                            <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                            @endforeach
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

            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0">
                    <thead class="bg-white text-gray-600">
                        <tr>
                            <th class="py-3 px-4 text-sm font-medium">No</th>
                            <th class="py-3 px-4 text-sm font-medium">Nama</th>
                            <th class="py-3 px-4 text-sm font-medium">NISN</th>
                            <th class="py-3 px-4 text-sm font-medium">Jumlah Hadir</th>
                            <th class="py-3 px-4 text-sm font-medium">Jumlah Izin</th>
                            <th class="py-3 px-4 text-sm font-medium">Jumlah Sakit</th>
                            <th class="py-3 px-4 text-sm font-medium">Jumlah Alpha</th>
                            <th class="py-3 px-4 text-sm font-medium">Persentase Kehadiran</th>
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
                            <td class="py-3 px-4 text-sm font-semibold text-blue-600">{{ $s->persentase_hadir }}%</td>
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