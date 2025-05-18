<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Kepala Sekolah
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-2xl">
            <form action="{{ route('kepalasekolah.update', $kepalasekolah->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama -->
                    <div>
                        <x-input label="Nama" name="nama" :value="old('nama', $kepalasekolah->nama)" required />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input label="Email" name="email" :value="old('email', $kepalasekolah->email)" required />
                    </div>

                    <!-- Password (opsional) -->
                    <div>
                        <x-input label="Password (Opsional)" name="password" type="password" />
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <x-input label="Konfirmasi Password" name="password_confirmation" type="password" />
                    </div>

                    <!-- NIP -->
                    <div>
                        <x-input label="NIP" name="nip" :value="old('nip', $kepalasekolah->nip)" required />
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <x-input label="Tanggal Lahir" name="tanggal_lahir" type="date" :value="old('tanggal_lahir', $kepalasekolah->tanggal_lahir)" />
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <x-select name="jenis_kelamin" label="Jenis Kelamin"
                            :options="['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan']"
                            :value="old('jenis_kelamin', $kepalasekolah->jenis_kelamin)" />
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <x-input label="Nomor Telepon" name="no_telepon" :value="old('no_telepon', $kepalasekolah->no_telepon)" required />
                    </div>

                    <!-- Status -->
                    <div>
                        <x-select name="status" label="Status" :options="['Aktif' => 'Aktif', 'Tidak Aktif' => 'Tidak Aktif']" />
                    </div>
                    <!-- Foto -->
                    <div>
                        @if($kepalasekolah->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/foto/' . $kepalasekolah->foto) }}" alt="Foto Kepala Sekolah" class="h-24 rounded shadow">
                        </div>
                        @endif
                        <x-input label="Foto (Upload baru jika ingin mengganti)" name="foto" type="file" />
                    </div>
                </div>

                <!-- Alamat -->
                <div class="mt-4">
                    {{-- Alamat --}}
                    <x-textarea name="alamat" label="Alamat Lengkap" :value="$kepalasekolah->alamat ?? ''" rows="4" />
                </div>

                {{-- Tombol --}}
                <div class="flex justify-end mt-8">
                    <a href="{{ route('kepalasekolah.index') }}"
                        class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-3 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                        Update Kepala Sekolah
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>