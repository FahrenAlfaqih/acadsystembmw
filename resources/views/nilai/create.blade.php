<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Input Nilai Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-xl">
            <form method="POST" action="{{ route('nilai.store', ['kelas_id' => $kelas_id, 'mapel_id' => $mapel_id, 'semester_id' => $semester_id]) }}">
                @csrf

                <div class="space-y-4">
                    <!-- Pilih Siswa -->
                    <x-select id="siswa_id" name="siswa_id" label="Pilih Siswa" :options="$siswaList->pluck('nama', 'id')" required />

                    <!-- Nilai Ulangan Harian -->
                    <x-input type="number" name="nilai_ulangan_harian" label="Nilai Ulangan Harian" min="0" max="100" />

                    <!-- Nilai Quiz -->
                    <x-input type="number" name="nilai_quiz" label="Nilai Quiz" min="0" max="100" />

                    <!-- Nilai Tugas -->
                    <x-input type="number" name="nilai_tugas" label="Nilai Tugas" min="0" max="100" />

                    <!-- Nilai UTS -->
                    <x-input type="number" name="nilai_uts" label="Nilai UTS" min="0" max="100" />

                    <!-- Nilai UAS -->
                    <x-input type="number" name="nilai_uas" label="Nilai UAS" min="0" max="100" />
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end mt-8">
                    <a href="{{ route('guru.dashboard') }}"
                        class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-3 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                        Simpan Nilai
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
            $('#siswa_id').select2({
                placeholder: "Pilih siswa...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
</x-app-layout>