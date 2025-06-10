<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Jadwal Mata Pelajaran
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-2xl">
            <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Menggunakan method PUT untuk update -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Kelas -->
                        <x-select name="kelas_id" label="Kelas" :options="$kelas->pluck('nama_kelas', 'id')" :selected="$jadwal->kelas_id" required />

                        <!-- Mata Pelajaran -->
                        <x-select name="mapel_id" label="Mata Pelajaran" :options="$mapels->pluck('nama_mapel', 'id')" :selected="$jadwal->mapel_id" required />

                        <!-- Guru -->
                        <x-select name="guru_id" label="Guru" :options="$guru->pluck('nama', 'id')" :selected="$jadwal->guru_id" required />
                        <!-- Semester -->
                        <x-input
                            label="Semester"
                            name="semester_id"
                            value="{{ $semesterAktif->nama }}"
                            readonly
                            required />

                        <input type="hidden" name="semester_id" value="{{ $semesterAktif->id }}">

                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <!-- Hari -->
                        <x-select name="hari" label="Hari" :options="[
    'Senin' => 'Senin', 
    'Selasa' => 'Selasa', 
    'Rabu' => 'Rabu', 
    'Kamis' => 'Kamis', 
    'Jumat' => 'Jumat', 
    'Sabtu' => 'Sabtu'
]" value="{{ old('hari', $jadwal->hari) }}" required />


                        <!-- Jam Mulai -->
                        <x-input
                            name="jam_mulai"
                            label="Jam Mulai"
                            type="time"
                            value="{{ old('jam_mulai', \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')) }}"
                            required />

                        <!-- Jam Selesai -->
                        <x-input
                            name="jam_selesai"
                            label="Jam Selesai"
                            type="time"
                            value="{{ old('jam_selesai', \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i')) }}"
                            required />

                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end mt-8">
                    <a href="{{ route('jadwal.index') }}"
                        class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-3 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                        Simpan Jadwal
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
            $('#kelas_id, #mapel_id, #guru_id').select2({
                placeholder: "-- Pilih --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
</x-app-layout>