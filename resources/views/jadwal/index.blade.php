<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jadwal Mata Pelajaran
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex flex-col items-end justify-end mb-2">
            @if(auth()->user()->role === 'tatausaha')
            <a href="{{ route('jadwal.create') }}"
                class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                Tambah Jadwal Pelajaran
            </a>
            @endif
        </div>

        {{-- Tabel Jadwal --}}
        <div class="bg-white p-6 shadow-md rounded-2xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800 mb-4 sm:mb-0">
                    Daftar Jadwal Pelajaran
                </h3>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 sm:ml-auto w-full sm:w-auto">
                    @if($semesterAktif)
                    <form action="{{ route('jadwal.filter') }}" method="GET" class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4">
                        <select name="semester_id" id="semester_id"
                            class="text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-300 text-black transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($semesters ?? \App\Models\Semester::all() as $semester)
                            <option value="{{ $semester->id }}" {{ (isset($semesterDipilih) && $semesterDipilih->id == $semester->id) ? 'selected' : '' }}>
                                {{ $semester->nama }}
                            </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="text-sm px-4 py-2 border border-blue-500 text-blue-600 rounded-lg shadow-sm transition hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                    </form>
                    @endif

                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Cari Jadwal..."
                        class="w-full sm:w-64 h-10 px-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                </div>
            </div>

            @if($jadwalPerSemester->isEmpty())
            <p class="text-gray-500">Data jadwal tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                @foreach($jadwalPerSemester as $semester => $jadwals)
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-2">
                    <thead>
                        <tr class="bg-white text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">No</th>
                            <th class="py-3 px-4 text-sm font-medium">Kelas</th>
                            <th class="py-3 px-4 text-sm font-medium">Mata Pelajaran</th>
                            <th class="py-3 px-4 text-sm font-medium">Guru</th>
                            <th class="py-3 px-4 text-sm font-medium">Hari</th>
                            <th class="py-3 px-4 text-sm font-medium">Jam Mulai</th>
                            <th class="py-3 px-4 text-sm font-medium">Jam Selesai</th>
                            @if(auth()->user()->role === 'tatausaha')
                            <th class="py-3 px-4 text-sm font-medium text-center">Aksi</th>
                            @endif

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
                                @if(auth()->user()->role === 'tatausaha')
                                <a href="{{ route('jadwal.edit', $item->id) }}" class="text-yellow-600 hover:underline">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('jadwal.destroy', $item->id) }}"
                                    method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="text-red-600 hover:underline btn-delete"
                                        data-id="{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @endif

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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const jadwalId = this.getAttribute('data-id');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data jadwal ini akan dihapus permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${jadwalId}`).submit();
                        }
                    });
                });
            });
        });
    </script>

    @endpush
</x-app-layout>