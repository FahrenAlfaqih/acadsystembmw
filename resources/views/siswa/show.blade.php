<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex items-center">
                <img src="{{ asset('storage/foto/' . $siswa->foto) }}" alt="Foto Siswa" class="w-32 h-32 object-cover rounded-full mr-6 border border-gray-300">
                <div>
                    <h3 class="text-2xl font-semibold text-gray-800">{{ $siswa->nama }}</h3>
                    <p class="text-sm text-gray-600">{{ $siswa->email }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4">
                <div>
                    <p class="text-sm text-gray-600">NISN</p>
                    <p class="text-lg font-medium">{{ $siswa->nisn }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Tanggal Lahir</p>
                    <p class="text-lg font-medium">{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Jenis Kelamin</p>
                    <p class="text-lg font-medium">{{ $siswa->jenis_kelamin }}</p>
                </div>



                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="text-lg font-medium">{{ $siswa->alamat }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Nama Orang Tua</p>
                    <p class="text-lg font-medium">{{ $siswa->orangtua }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $siswa->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $siswa->status }}
                    </span>
                </div>

                <div>
                    <p class="text-sm text-gray-600">No Telepon Orang Tua</p>
                    <p class="text-lg font-medium">
                        {{ $siswa->no_telepon }}
                    </p>
                    <a href="https://wa.me/{{ '62' . ltrim($siswa->no_telepon, '0') }}?text={{ urlencode('Selamat Pagi/Siang/Sore orangtua siswa ' . $siswa->nama . ', kami dari pihak Tata Usaha SMA Bina Mitra Wahana') }}"
                        target="_blank"
                        class="inline-block mt-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg shadow">
                        Hubungi via WhatsApp
                    </a>
                </div>


                <div>
                    <p class="text-sm text-gray-600">Kelas</p>
                    <p class="text-lg font-medium">
                        {{ $siswa->kelas ? $siswa->kelas->nama_kelas : 'Kelas Tidak Ditemukan' }}
                    </p>
                </div>
            </div>

            <!-- <div class="mt-6">
                <a href="{{ route('siswa.index') }}" class="inline-block px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow">
                    Kembali ke Daftar Siswa
                </a>
            </div> -->
        </div>
    </div>
</x-app-layout>