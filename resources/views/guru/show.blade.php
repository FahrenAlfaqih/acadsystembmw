<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Guru
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex items-center">
                <img src="{{ asset('storage/foto/' . $guru->foto) }}" alt="Foto Guru" class="w-32 h-32 object-cover rounded-full mr-6 border border-gray-300">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $guru->nama }}</h3>
                    <p class="text-sm text-gray-600">{{ $guru->email }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                <div>
                    <p class="text-sm text-gray-600">NIP</p>
                    <p class="text-lg font-medium">{{ $guru->nip }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Tanggal Lahir</p>
                    <p class="text-lg font-medium">{{ \Carbon\Carbon::parse($guru->tanggal_lahir)->format('d M Y') }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Jenis Kelamin</p>
                    <p class="text-lg font-medium">{{ $guru->jenis_kelamin }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">No Telepon</p>
                    <p class="text-lg font-medium">{{ $guru->no_telepon }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="text-lg font-medium">{{ $guru->alamat }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $guru->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $guru->status }}
                    </span>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Sebagai Wali Kelas?</p>
                    <p class="text-lg font-medium">
                        {{ $guru->is_wali_kelas ? 'Ya' : 'Tidak' }}
                    </p>
                </div>

                @if($guru->is_wali_kelas && $guru->kelas)
                <div>
                    <p class="text-sm text-gray-600">Wali Dari Kelas</p>
                    <p class="text-lg font-medium">{{ $guru->kelas->nama_kelas }}</p>
                </div>
                @endif

            </div>

            <div class="mt-6">
                <a href="{{ route('guru.index') }}" class="inline-block px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow">
                    Kembali ke Daftar Guru
                </a>
            </div>
        </div>
    </div>
</x-app-layout>