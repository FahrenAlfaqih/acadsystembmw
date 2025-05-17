<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $mapel->nama_mapel }} - {{ $kelas->nama_kelas }} - {{ $semester->nama }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <form method="POST" action="{{ route('presensi.store', ['kelas_id' => $kelas_id, 'mapel_id' => $mapel_id, 'semester_id' => $semester_id]) }}">
                @csrf

                <!-- Pertemuan dan Tanggal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input label="Pertemuan Ke" name="pertemuan_ke" type="number" min="1" max="36" required />
                    </div>

                    <div>
                        <x-input label="Tanggal Absensi" name="tanggal" type="date" :value="old('tanggal', date('Y-m-d'))" required />
                    </div>
                </div>

                <!-- Tabel Absensi -->
                <div class="overflow-x-auto mt-6">
                    <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600">
                                <th class="py-3 px-4 text-sm font-medium">Nama Siswa</th>
                                <th class="py-3 px-4 text-sm font-medium">NISN</th>
                                <th class="py-3 px-4 text-sm font-medium">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswaList as $siswa)
                            <tr class="border-b hover:bg-gray-50 transition duration-300">
                                <td class="py-3 px-4 text-sm">{{ $siswa->nama }}</td>
                                <td class="py-3 px-4 text-sm">{{ $siswa->nisn }}</td>
                                <td class="py-3 px-4 text-sm ">
                                    <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                    <div class="flex flex-wrap gap-4">
                                        <label><input type="radio" name="status_kehadiran[{{ $siswa->id }}]" value="Hadir" required> Hadir</label>
                                        <label><input type="radio" name="status_kehadiran[{{ $siswa->id }}]" value="Alpha"> Alpha</label>
                                        <label><input type="radio" name="status_kehadiran[{{ $siswa->id }}]" value="Izin"> Izin</label>
                                        <label><input type="radio" name="status_kehadiran[{{ $siswa->id }}]" value="Sakit"> Sakit</label>
                                    </div>
                                    @error("status_kehadiran.{$siswa->id}")
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end mt-8">
                    <a href="{{ url()->previous() }}"
                        class="inline-block px-6 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium text-sm rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg ml-3 shadow-md transition">
                        Simpan Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#semester_id').select2({
                placeholder: "-- Pilih Semester --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush

</x-app-layout>