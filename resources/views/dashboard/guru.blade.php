<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jadwal Mata Pelajaran
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <p>Selamat datang, {{ auth()->user()->name }}</p>

        <!-- Tombol untuk switch tampilan -->
        <div class="mb-4 flex justify-end space-x-4">
            <button id="toggle-card" class="px-4 py-2 text-sm font-medium text-white bg-indigo-500 hover:bg-indigo-700 rounded-lg">
                Tampilkan sebagai Card
            </button>
            <button id="toggle-table" class="px-4 py-2 text-sm font-medium text-white bg-gray-500 hover:bg-gray-700 rounded-lg">
                Tampilkan sebagai Table
            </button>
        </div>

        <div class="bg-white p-6 shadow-md rounded-2xl">

            @if($jadwal->isEmpty())
            <p class="mt-2 text-gray-500">Data Jadwal Pelajaran tidak tersedia.</p>
            @else
            <div id="card-view" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach ($jadwal as $item)
                <div class="bg-white shadow-lg hover:shadow-2xl transition-shadow rounded-2xl overflow-hidden border border-gray-200 group">
                    <div class="p-5">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2 hover:text-blue-600">{{ $item->mapel->nama_mapel }}</h3>
                        <p class="text-sm text-gray-500 mb-1"><i class="fas fa-chalkboard mr-2"></i> Kelas: <span class="font-medium">{{ $item->kelas->nama_kelas }}</span></p>
                        <p class="text-sm text-gray-500 mb-1"><i class="fas fa-calendar-day mr-2"></i> Hari: <span class="font-medium">{{ $item->hari }}</span></p>
                        <p class="text-sm text-gray-500 mb-1"><i class="fas fa-clock mr-2"></i> Jam: <span class="font-medium">{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</span></p>
                        <p class="text-sm text-gray-500 mb-2">
                            <i class="fas fa-layer-group mr-2"></i>
                            <span class="font-medium">{{ $item->semester->nama }}</span>
                        </p>
                    </div>

                    <div class="px-5 pb-5 flex flex-wrap gap-3">
                        <a href="{{ route('presensi.create', ['kelas_id' => $item->kelas->id, 'mapel_id' => $item->mapel->id, 'semester_id' => $item->semester->id]) }}"
                            class="flex-1 text-center bg-indigo-100 text-indigo-800 px-5 py-3 text-sm font-medium rounded-xl hover:bg-indigo-200 hover:text-indigo-900 transition-all transform hover:scale-105 shadow-sm">
                            Isi Presensi
                        </a>

                        <a href="{{ route('rekap.presensi', ['kelas_id' => $item->kelas->id, 'semester_id' => $item->semester->id, 'mapel_id' => $item->mapel->id]) }}"
                            class="flex-1 text-center bg-cyan-100 text-cyan-800 px-5 py-3 text-sm font-medium rounded-xl hover:bg-cyan-200 hover:text-cyan-900 transition-all transform hover:scale-105 shadow-sm">
                            Rekap Presensi
                        </a>

                        <a href="{{ route('nilai.create', ['kelas_id' => $item->kelas->id, 'mapel_id' => $item->mapel->id, 'semester_id' => $item->semester->id]) }}"
                            class="flex-1 text-center bg-violet-100 text-violet-800 px-5 py-3 text-sm font-medium rounded-xl hover:bg-violet-200 hover:text-violet-900 transition-all transform hover:scale-105 shadow-sm">
                            Isi Nilai
                        </a>

                        <a href="{{ route('rekap.nilai', ['kelas_id' => $item->kelas->id, 'semester_id' => $item->semester->id, 'mapel_id' => $item->mapel->id]) }}"
                            class="flex-1 text-center bg-emerald-100 text-emerald-800 px-5 py-3 text-sm font-medium rounded-xl hover:bg-emerald-200 hover:text-emerald-900 transition-all transform hover:scale-105 shadow-sm">
                            Rekap Nilai
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Tabel View -->
            <div id="table-view" class="hidden">
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600">
                                <th class="py-3 px-4 text-sm font-medium">Mata Pelajaran</th>
                                <th class="py-3 px-4 text-sm font-medium">Kelas</th>
                                <th class="py-3 px-4 text-sm font-medium">Hari</th>
                                <th class="py-3 px-4 text-sm font-medium">Jam Mulai</th>
                                <th class="py-3 px-4 text-sm font-medium">Jam Selesai</th>
                                <th class="py-3 px-4 text-sm font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwal as $item)
                            <tr class="border-b hover:bg-gray-50 transition duration-300">
                                <td class="py-3 px-4 text-sm">{{ $item->mapel->nama_mapel }}</td>
                                <td class="py-3 px-4 text-sm">{{ $item->kelas->nama_kelas }}</td>
                                <td class="py-3 px-4 text-sm">{{ $item->hari }}</td>
                                <td class="py-3 px-4 text-sm">{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}</td>
                                <td class="py-3 px-4 text-sm">{{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</td>
                                <td class="py-3 px-4 text-sm">
                                    <select class="block w-full py-2 px-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="window.location.href=this.value">
                                        <option value="">Pilih Aksi</option>
                                        <option value="{{ route('presensi.create', ['kelas_id' => $item->kelas->id, 'mapel_id' => $item->mapel->id, 'semester_id' => $item->semester->id]) }}">
                                            Isi Presensi
                                        </option>
                                        <option value="{{ route('rekap.presensi', ['kelas_id' => $item->kelas->id, 'semester_id' => $item->semester->id, 'mapel_id' => $item->mapel->id]) }}">
                                            Rekap Presensi
                                        </option>
                                        <option value="{{ route('nilai.create', ['kelas_id' => $item->kelas->id, 'mapel_id' => $item->mapel->id, 'semester_id' => $item->semester->id]) }}">
                                            Isi Nilai
                                        </option>
                                        <option value="{{ route('rekap.nilai', ['kelas_id' => $item->kelas->id, 'semester_id' => $item->semester->id, 'mapel_id' => $item->mapel->id]) }}">
                                            Rekap Nilai
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @endif
        </div>
    </div>

    <script>
        document.getElementById("toggle-card").addEventListener("click", function() {
            document.getElementById("card-view").classList.remove("hidden");
            document.getElementById("table-view").classList.add("hidden");
        });

        document.getElementById("toggle-table").addEventListener("click", function() {
            document.getElementById("table-view").classList.remove("hidden");
            document.getElementById("card-view").classList.add("hidden");
        });
    </script>
</x-app-layout>