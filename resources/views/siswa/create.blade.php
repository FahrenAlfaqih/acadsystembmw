<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <form action="{{ route('siswa.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Nama -->
                        <x-input label="Nama" name="nama" required />

                        <!-- Email -->
                        <x-input label="Email" name="email" type="email" required />

                        <!-- Password -->
                        <x-input label="Password" name="password" type="password" required />

                        <!-- Konfirmasi Password -->
                        <x-input label="Konfirmasi Password" name="password_confirmation" type="password" required />

                        <!-- NISN -->
                        <x-input label="NISN" name="nisn" required />

                        <!-- Tanggal Lahir -->
                        <x-input label="Tanggal Lahir" name="tanggal_lahir" type="date" />
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-4">
                        <!-- Jenis Kelamin -->
                        <x-select label="Jenis Kelamin" name="jenis_kelamin" :options="['Laki-laki', 'Perempuan']" />

                        <!-- Alamat -->
                        <x-textarea label="Alamat" name="alamat" rows="3" />

                        <!-- No Telepon -->
                        <x-input label="No Telepon" name="no_telepon" />

                        <!-- Kelas -->
                        <x-select label="Kelas" name="kelas_id" :options="$kelas->pluck('nama_kelas', 'id')" required />


                        <!-- Status -->
                        <x-select name="status" label="Status" :options="['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']" />


                        <!-- Nama Orang Tua -->
                        <x-input label="Nama Orang Tua" name="orangtua" />

                        <!-- Foto -->
                        <x-input label="Foto" name="foto" type="file" />
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end mt-8">
                    <a href="{{ route('siswa.index') }}"
                        class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-3 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                        Simpan Siswa
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
            $('#kelas_id, #status, #jenis_kelamin').select2({
                placeholder: "-- Pilih --",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
</x-app-layout>