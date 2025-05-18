<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Semester
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-col items-end justify-end mb-2">
            <a href="{{ route('semester.create') }}"
                class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">Tambah Semester</a>
        </div>
        <div class="bg-white p-6 shadow-md rounded-2xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    Daftar Semester
                </h3>
                <div class="mb-4">
                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari Semester..."
                        class="w-full sm:w-64 h-10 px-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>

            </div>


            @if($semesters->isEmpty())
            <p class="mt-2 text-gray-500">Data semester tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                    <thead>
                        <tr class="bg-white text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">No</th>
                            <th class="py-3 px-4 text-sm font-medium">Nama</th>
                            <th class="py-3 px-4 text-sm font-medium">Tahun Ajaran</th>
                            <th class="py-3 px-4 text-sm font-medium">Tipe</th>
                            <th class="py-3 px-4 text-sm font-medium">Status</th>
                            <th class="py-3 px-4 text-sm font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semesters as $key => $semester)
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $key+1 }}</td>
                            <td class="py-3 px-4 text-sm">{{ $semester->nama }}</td>
                            <td class="py-3 px-4 text-sm">{{ $semester->tahun_ajaran }}</td>
                            <td class="py-3 px-4 text-sm">{{ $semester->tipe }}</td>
                            <td class="py-3 px-4 text-sm">
                                @if ($semester->is_aktif)
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded">Aktif</span>
                                @else
                                <span class="inline-block px-2 py-1 text-xs font-semibold text-gray-500 bg-gray-100 rounded">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm">
                                <a href="{{ route('semester.edit', $semester->id) }}"
                                    class="text-yellow-600 hover:text-blue-800"><i class="fa-solid fa-pen-to-square"></i></a>
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