<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Kepala Sekolah
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-md rounded-2xl p-6 mb-6">
            <div class="flex items-center">
                <img src="{{ asset('storage/foto/' . $kepalasekolah->foto) }}" alt="Foto Kepala Sekolah" class="w-32 h-32 object-cover rounded-full mr-6 border border-gray-300">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $kepalasekolah->nama }}</h3>
                    <p class="text-sm text-gray-600">{{ $kepalasekolah->email }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-2xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                <div>
                    <p class="text-sm text-gray-600">NIP</p>
                    <p class="text-lg font-medium">{{ $kepalasekolah->nip }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Tanggal Lahir</p>
                    <p class="text-lg font-medium">{{ \Carbon\Carbon::parse($kepalasekolah->tanggal_lahir)->format('d M Y') }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Jenis Kelamin</p>
                    <p class="text-lg font-medium">{{ $kepalasekolah->jenis_kelamin }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">No Telepon</p>
                    <p class="text-lg font-medium">{{ $kepalasekolah->no_telepon }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="text-lg font-medium">{{ $kepalasekolah->alamat }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $kepalasekolah->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $kepalasekolah->status }}
                    </span>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('kepalasekolah.index') }}" class="inline-block px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow">
                    Kembali ke Data Kepala Sekolah
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
