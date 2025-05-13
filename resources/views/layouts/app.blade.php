<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')


</head>
<!-- SweetAlert2 JS -->

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-100 flex">

        <!-- Sidebar -->
        <div class="mt-3 ml-3  mb-3 w-64 bg-white text-black p-4 shadow-md rounded-lg">
            <!-- Logo dan Nama Sistem -->
            <div class="flex items-center mb-6">
                @php
                $foto = null;
                if(auth()->user()->guru) {
                $foto = auth()->user()->guru->foto;
                } elseif(auth()->user()->siswa) {
                $foto = auth()->user()->siswa->foto;
                } elseif(auth()->user()->kepalaSekolah) {
                $foto = auth()->user()->kepalaSekolah->foto;
                }
                @endphp
                @if($foto)
                <img src="{{ asset('storage/foto/' . $foto) }}" alt="Foto Pengguna" class="w-32 h-32 object-cover rounded-full mr-6 border border-gray-300">
                @else
                @endif
            </div>


            <!-- Menu -->
            <nav class="space-y-4">
                <!-- Dashboard -->
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="w-full px-4 py-2 text-left rounded-md {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                    Dashboard
                </x-nav-link>


                <!-- Wrapper menu -->
                <div class="space-y-2">

                    @if(auth()->user()->role === 'tatausaha')
                    <x-nav-link :href="route('guru.index')"
                        :active="request()->routeIs('guru.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('guru.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Guru
                    </x-nav-link>
                    <x-nav-link :href="route('siswa.index')"
                        :active="request()->routeIs('siswa.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('siswa.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Siswa
                    </x-nav-link>
                    <x-nav-link :href="route('kepalasekolah.index')"
                        :active="request()->routeIs('kepalasekolah.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('kepalasekolah.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Kepala Sekolah
                    </x-nav-link>
                    <x-nav-link :href="route('semester.index')"
                        :active="request()->routeIs('semester.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('semester.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Semester
                    </x-nav-link>
                    <x-nav-link :href="route('mapel.index')"
                        :active="request()->routeIs('mapel.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('mapel.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Mata Pelajaran
                    </x-nav-link>
                    <x-nav-link :href="route('kelas.index')"
                        :active="request()->routeIs('kelas.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('kelas.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Kelas
                    </x-nav-link>
                    <x-nav-link :href="route('jadwal.index')"
                        :active="request()->routeIs('jadwal.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('jadwal.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Jadwal Mapel
                    </x-nav-link>
                    @elseif(auth()->user()->role === 'siswa')
                    <x-nav-link :href="route('nilai.index')"
                        :active="request()->routeIs('nilai.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('nilai.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Nilai
                    </x-nav-link>
                    <x-nav-link :href="route('presensi.index')"
                        :active="request()->routeIs('presensi.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       {{ request()->routeIs('presensi.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Presensi
                    </x-nav-link>
                    @elseif(auth()->user()->role === 'guru')
                    <x-nav-link :href="route('nilai.guru.index')"
                        :active="request()->routeIs('nilai.guru.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
       {{ request()->routeIs('nilai.guru.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Nilai
                    </x-nav-link>

                    <x-nav-link :href="route('presensi.guru.index')"
                        :active="request()->routeIs('presensi.guru.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
       {{ request()->routeIs('presensi.guru.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Presensi
                    </x-nav-link>

                    @if(auth()->user()->guru && auth()->user()->guru->is_wali_kelas == 1)
                    <x-nav-link :href="route('kenaikan-kelas.index')"
                        :active="request()->routeIs('kenaikan-kelas.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
            {{ request()->routeIs('kenaikan-kelas.index') ? 'bg-blue-500 text-white' : 'text-gray-700' }}">
                        Data Kenaikan Kelas
                    </x-nav-link>
                    @endif
                    @endif



                </div>
            </nav>
        </div>

        <!-- Konten Utama -->
        <div class="flex-1 bg-gray-180 p-6">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
            <header class="bg-white shadow rounded-lg">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
                @include('sweetalert::alert')
            </main>
            @stack('scripts')
        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdowns = [{
                    buttonId: 'siswaDropdown',
                    menuId: 'siswaDropdownMenu'
                },
                {
                    buttonId: 'guruDropdown',
                    menuId: 'guruDropdownMenu'
                },
                {
                    buttonId: 'kepalasekolahDropdown',
                    menuId: 'kepalasekolahDropdownMenu'
                },
                {
                    buttonId: 'mapelDropdown',
                    menuId: 'mapelDropdownMenu'
                },
                {
                    buttonId: 'kelasDropdown',
                    menuId: 'kelasDropdownMenu'
                },
                {
                    buttonId: 'jadwalDropdown',
                    menuId: 'jadwalDropdownMenu'
                }
            ];

            dropdowns.forEach(({
                buttonId,
                menuId
            }) => {
                const button = document.getElementById(buttonId);
                const menu = document.getElementById(menuId);

                if (button && menu) {
                    button.addEventListener('click', function() {
                        const isOpen = menu.classList.contains('block');

                        // Sembunyikan semua dropdown lain
                        dropdowns.forEach(({
                            menuId: otherMenuId
                        }) => {
                            const otherMenu = document.getElementById(otherMenuId);
                            if (otherMenu && otherMenu !== menu) {
                                otherMenu.classList.add('hidden');
                                otherMenu.classList.remove('block');
                            }
                        });

                        // Toggle menu yang diklik
                        if (isOpen) {
                            menu.classList.add('hidden');
                            menu.classList.remove('block');
                        } else {
                            menu.classList.remove('hidden');
                            menu.classList.add('block');
                        }
                    });
                }
            });

            // Klik di luar menu akan menutup dropdown
            document.addEventListener('click', function(event) {
                const isClickInsideDropdown = dropdowns.some(({
                    buttonId,
                    menuId
                }) => {
                    const button = document.getElementById(buttonId);
                    const menu = document.getElementById(menuId);
                    return button?.contains(event.target) || menu?.contains(event.target);
                });

                if (!isClickInsideDropdown) {
                    dropdowns.forEach(({
                        menuId
                    }) => {
                        const menu = document.getElementById(menuId);
                        if (menu) {
                            menu.classList.add('hidden');
                            menu.classList.remove('block');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>