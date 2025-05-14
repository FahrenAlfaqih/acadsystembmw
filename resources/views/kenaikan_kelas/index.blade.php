<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Kenaikan Kelas - Wali Kelas
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('kenaikan-kelas.proses') }}">
            @csrf
            <div class="bg-white p-6 shadow-md rounded-lg mb-6">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Menu Kenaikan Kelas</h3>

                <div class="flex flex-wrap gap-3 sm:gap-4 items-end">
                    <!-- Pilih Kelas Baru -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kelas Baru</label>
                        <select name="kelas_baru_id" id="kelas_baru_id"
                            class="text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($kelas as $kelasItem)
                            <option value="{{ $kelasItem->id }}" {{ $kelasItem->id == request()->kelas_baru_id ? 'selected' : '' }}>
                                {{ $kelasItem->nama_kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Pilih Tahun Ajaran -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                        <select name="tahun_ajaran" id="tahun_ajaran"
                            class="text-sm px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-white text-gray-700 transition hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($tahunAjaran as $tahun)
                            <option value="{{ $tahun }}" {{ $tahun == request()->tahun_ajaran ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 shadow-md rounded-lg">
                <!-- Daftar Siswa -->
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Pilih siswa yang akan naik kelas:</p>

                    @if($siswa->isEmpty())
                    <p class="mt-2 text-gray-500">Data siswa tidak tersedia.</p>
                    @else
                    <div class="overflow-x-auto mt-4">
                        <table class="w-full table-auto text-left border-separate border-spacing-0">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600">
                                    <th class="py-3 px-4 text-sm font-medium">Nama</th>
                                    <th class="py-3 px-4 text-sm font-medium">NISN</th>
                                    <th class="py-3 px-4 text-sm font-medium">Kelas Saat Ini</th>
                                    <th class="py-3 px-4 text-sm font-medium">Status</th>
                                    <th class="py-3 px-4 text-sm font-medium">Naik Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswa as $data)
                                <tr class="border-b hover:bg-gray-50 transition duration-300">
                                    <td class="py-3 px-4 text-sm">{{ $data->nama }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $data->nisn }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $data->kelas->nama_kelas ?? '-' }}</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                                            {{ $data->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $data->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <input type="checkbox" name="siswa_ids[]" value="{{ $data->id }}"
                                            class="form-checkbox h-4 w-4 text-blue-600">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                <!-- Tombol Submit -->
                <div class="mt-6">
                    <button type="submit"
                        class="text-sm px-4 py-2 bg-blue-600 text-white rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <i class="fas fa-cog mr-1"></i> Proses Kenaikan Kelas
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>