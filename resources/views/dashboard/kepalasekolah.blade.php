<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                SMA Bina Mitra Wahana
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="mb-6">Selamat datang, {{ auth()->user()->name }}</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">

                <!-- Card Guru -->
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <h3 class="text-sm text-gray-500">Total Guru</h3>
                        <p class="text-2xl font-bold">{{ $totalGuru }}</p>
                    </div>
                    <div class="text-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0zm6 4a4 4 0 00-3-3.87M4 11a4 4 0 013-3.87" />
                        </svg>
                    </div>
                </div>

                <!-- Card Siswa -->
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <h3 class="text-sm text-gray-500">Total Siswa</h3>
                        <p class="text-2xl font-bold">{{ $totalSiswa }}</p>
                    </div>
                    <div class="text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.658 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Card Mapel -->
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <h3 class="text-sm text-gray-500">Total Mapel</h3>
                        <p class="text-2xl font-bold">{{ $totalMapel }}</p>
                    </div>
                    <div class="text-yellow-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 20l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 12l9-5-9-5-9 5 9 5z" />
                        </svg>
                    </div>
                </div>

                <!-- Card Kelas -->
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center justify-between">
                    <div>
                        <h3 class="text-sm text-gray-500">Total Kelas</h3>
                        <p class="text-2xl font-bold">{{ $totalKelas }}</p>
                    </div>
                    <div class="text-purple-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="ro    und" stroke-width="2"
                                d="M3 10h18M4 6h16M4 14h16M5 18h14" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6">
                <!-- Card Informasi Sekolah -->
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col">
                    <h3 class="text-lg font-semibold text-gray-700 text-left bg-gray-200 p-2 rounded-md">
                        SMAS Bina Mitra Wahana
                    </h3>
                    <div class="space-y-4 mt-4">
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">NPSN:</span>
                            <span class="text-left">{{ $sekolah->npsn }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">Bentuk Pendidikan:</span>
                            <span class="text-left">{{ $sekolah->bentuk_pendidikan }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">Status:</span>
                            <span class="text-left">{{ $sekolah->status }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">Kecamatan:</span>
                            <span class="text-left">{{ $sekolah->kecamatan }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">Kabupaten:</span>
                            <span class="text-left">{{ $sekolah->kabupaten }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">Provinsi:</span>
                            <span class="text-left">{{ $sekolah->provinsi }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">Kepala Sekolah:</span>
                            <span class="text-left">{{ $sekolah->kepala_sekolah }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">Operator:</span>
                            <span class="text-left">{{ $sekolah->operator }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <span class="font-medium text-gray-600">Username:</span>
                            <span class="text-left">{{ $sekolah->username }}</span>
                        </div>
                    </div>


                </div>

                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold text-gray-700 text-left bg-gray-200 p-2 rounded-md">
                        Kalender Kegiatan
                    </h3>

                    <img src="https://smasdarussaadahglp3.sch.id/media_library/posts/large/720ac6cb267fe65bf124bdde660422f2.png" alt=""
                    class="w-full rounded-md shadow-md">
                </div>
                

            </div>

        </div>
    </div>
    </div>
</x-app-layout>