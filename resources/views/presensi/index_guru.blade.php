<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Presensi Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-2xl">
            @if ($presensiList->isEmpty())
            <p class="text-gray-500">Data presensi tidak tersedia.</p>
            @else
            <div class="flex flex-wrap sm:flex-nowrap justify-between items-end mb-4">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Presensi Siswa</h3>
                <form method="GET" class="flex flex-wrap gap-4">
                    {{-- Semester --}}
                    <div>
                        <select name="semester_id" class="text-sm px-3 py-2 border border-gray-300 rounded-2xl bg-gray-300 text-black font-medium  shadow-sm">
                            @foreach ($semesters as $sem)
                            <option value="{{ $sem->id }}" {{ $sem->id == $semester_id ? 'selected' : '' }}>
                                Semester {{ $loop->iteration }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kelas --}}
                    <div>
                        <select name="kelas_id" class="text-sm px-3 py-2 border border-gray-300 rounded-2xl bg-gray-300 text-black font-medium  shadow-sm">
                            <option value="">-- Kelas --</option>
                            @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelas->id == $kelas_id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Mapel --}}
                    <div>
                        <select name="mapel_id" class="text-sm px-3 py-2 border border-gray-300 rounded-2xl bg-gray-300 text-black font-medium  shadow-sm">
                            <option value="">-- Mata Pelajaran --</option>
                            @foreach ($mapelList as $mapel)
                            <option value="{{ $mapel->id }}" {{ $mapel->id == $mapel_id ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Filter --}}
                    <div class="flex items-end">
                        <button type="submit"
                            class="text-sm px-4 py-2 border border-blue-500 text-blue-600 rounded-2xl hover:bg-blue-50 transition">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <div class="flex flex-wrap gap-2">
                    @php
                    $pertemuanAktif = request()->get('pertemuan_ke');
                    $tanggalPertemuan = $presensiList->groupBy('pertemuan_ke')->map(function($group) {
                    return $group->first()->tanggal;
                    });
                    @endphp

                    @foreach ($presensiList->pluck('pertemuan_ke')->unique()->sort() as $pertemuanKe)
                    @php
                    $tanggal = $tanggalPertemuan[$pertemuanKe] ?? null;
                    $formattedTanggal = $tanggal ? \Carbon\Carbon::parse($tanggal)->format('d M Y') : '-';
                    @endphp
                    <a href="{{ request()->fullUrlWithQuery(['pertemuan_ke' => $pertemuanKe]) }}"
                        class="text-sm px-3 py-1.5 border rounded-2xl transition
            {{ $pertemuanAktif == $pertemuanKe ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-blue-100' }}">
                        P{{ $pertemuanKe }} - {{ $formattedTanggal }}
                    </a>
                    @endforeach


                    <a href="{{ request()->url() }}"
                        class="text-sm px-3 py-1.5 border rounded-2xl transition
                {{ is_null($pertemuanAktif) ? 'bg-blue-500 text-white' : 'bg-white text-gray-700 hover:bg-blue-100' }}">
                        Tampilkan Semua
                    </a>
                </div>
            </div>


            {{-- Tabel Data --}}
            @foreach ($presensiList->groupBy('pertemuan_ke') as $pertemuanKe => $groupedPresensi)
            {{-- Cek jika filter aktif dan pertemuan ini bukan yang dipilih, maka sembunyikan --}}
            <div class="presensi-group" data-pertemuan="{{ $pertemuanKe }}"
                style="{{ $pertemuanAktif && $pertemuanAktif != $pertemuanKe ? 'display:none;' : '' }}">
                <div class="overflow-x-auto mb-4">
                    <table class="w-full table-auto text-left border-separate border-spacing-0">
                        <thead>
                            <tr class="bg-white text-gray-600">
                                <th class="py-3 px-4 text-sm font-medium">No</th>
                                <th class="py-3 px-4 text-sm font-medium">Nama Siswa</th>
                                <th class="py-3 px-4 text-sm font-medium">Kelas</th>
                                <th class="py-3 px-4 text-sm font-medium">Mapel</th>
                                <th class="py-3 px-4 text-sm font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groupedPresensi as $key => $presensi)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-4 text-sm">{{ $key + 1 }}</td>
                                <td class="py-3 px-4 text-sm">{{ $presensi->siswa->nama ?? '-' }}</td>
                                <td class="py-3 px-4 text-sm">{{ $presensi->kelas->nama_kelas ?? '-' }}</td>
                                <td class="py-3 px-4 text-sm">{{ $presensi->mapel->nama_mapel ?? '-' }}</td>
                                <td class="py-3 px-4 text-sm">{{ $presensi->status_kehadiran ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</x-app-layout>