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
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')


</head>
<!-- SweetAlert2 JS -->

<body class="font-sans antialiased">
    <div class="min-h-screen flex">

        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-full w-64 text-black p-4 shadow-md rounded-r-lg overflow-auto">
            <!-- Logo dan Nama Sistem -->
            <div class="flex justify-center mb-6 mt-3">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('build/assets/img/logo-apps.png') }}" alt="Logo" class="h-14 w-auto">
                </a>
            </div>

            <!-- Menu -->
            <nav class="flex flex-col items-center space-y-4">
                <x-nav-link :href="route('dashboard')"
                    :active="request()->routeIs('dashboard')"
                    icon="fa-solid fa-house"
                    class="w-full px-4 py-2 text-left rounded-md">
                    Dashboard
                </x-nav-link>
                <div class="space-y-2 ">
                    @if(auth()->user()->role === 'admin')
                    <x-nav-link :href="route('guru.index')"
                        :active="request()->routeIs('guru.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Tambah Pengguna Guru
                    </x-nav-link>
                    <x-nav-link :href="route('siswa.index')"
                        :active="request()->routeIs('siswa.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Tambah Pengguna Siswa
                    </x-nav-link>
                    <x-nav-link :href="route('kepalasekolah.index')"
                        :active="request()->routeIs('kepalasekolah.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Tambah Pengguna Kepala Sekolah
                    </x-nav-link>

                    @elseif(auth()->user()->role === 'tatausaha')
                    <x-nav-link :href="route('siswa.index')"
                        :active="request()->routeIs('siswa.index')"
                        icon="fa-solid fa-user"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Data Siswa
                    </x-nav-link>
                    <x-nav-link :href="route('guru.index')"
                        :active="request()->routeIs('guru.index')"
                        icon="fa-solid fa-user"
                        class="w-full px-4 py-2 text-left rounded-md ">
                        Data Guru
                    </x-nav-link>

                    <x-nav-link :href="route('kepalasekolah.index')"
                        :active="request()->routeIs('kepalasekolah.index')"
                        icon="fa-solid fa-user"
                        class="w-full px-4 py-2 text-left rounded-md 
                      ">
                        Data Kepala Sekolah
                    </x-nav-link>
                    <x-nav-link :href="route('semester.index')"
                        :active="request()->routeIs('semester.index')"
                        icon="fa-solid fa-chart-simple"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Data Semester
                    </x-nav-link>
                    <x-nav-link :href="route('mapel.index')"
                        :active="request()->routeIs('mapel.index')"
                        icon="fa-solid fa-chart-simple"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Data Mata Pelajaran
                    </x-nav-link>
                    <x-nav-link :href="route('kelas.index')"
                        :active="request()->routeIs('kelas.index')"
                        icon="fa-solid fa-chart-simple"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Data Kelas
                    </x-nav-link>
                    <x-nav-link :href="route('jadwal.index')"
                        :active="request()->routeIs('jadwal.index')"
                        icon="fa-solid fa-calendar"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Data Jadwal Mapel
                    </x-nav-link>
                    <x-nav-link :href="route('rapor.index')"
                        :active="request()->routeIs('rapor.index')"
                        icon="fa-solid fa-book"
                        class="w-full px-4 py-2 text-left rounded-md 
                       ">
                        Cetak Rapor
                    </x-nav-link>
                    @elseif(auth()->user()->role === 'siswa')
                    <x-nav-link :href="route('nilai.index')"
                        :active="request()->routeIs('nilai.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
        ">
                        Data Nilai
                    </x-nav-link>
                    <x-nav-link :href="route('presensi.index')"
                        :active="request()->routeIs('presensi.index')"
                        class="w-full px-4 py-2 text-left rounded-md 
                    ">
                        Data Presensi
                    </x-nav-link>
                    @elseif(auth()->user()->role === 'guru')
                    <x-nav-link :href="route('nilai.guru.index')"
                        :active="request()->routeIs('nilai.guru.index')"
                        icon="fa-solid fa-chart-simple"
                        class="w-full px-4 py-2 text-left rounded-md">
                        Data Nilai
                    </x-nav-link>

                    <x-nav-link :href="route('presensi.guru.index')"
                        :active="request()->routeIs('presensi.guru.index')"
                        icon="fa-solid fa-chart-simple"
                        class="w-full px-4 py-2 text-left rounded-md">
                        Data Presensi
                    </x-nav-link>

                    @if(auth()->user()->guru && auth()->user()->guru->is_wali_kelas == 1)

                    <x-nav-link :href="route('wali-kelas-siswa.index')"
                        :active="request()->routeIs('wali-kelas-siswa.index')"
                        icon="fa-solid fa-user"
                        class="w-full px-4 py-2 text-left rounded-md">
                        Data Siswa
                    </x-nav-link>
                    <x-nav-link :href="route('wali-kelas-siswaNilai.index')"
                        :active="request()->routeIs('wali-kelas-siswaNilai.index')"
                        icon="fa-solid fa-chart-simple"

                        class="w-full px-4 py-2 text-left rounded-md ">
                        Data Nilai Siswa
                    </x-nav-link>
                    <x-nav-link :href="route('wali-kelas-siswaPresensi.index')"
                        :active="request()->routeIs('wali-kelas-siswaPresensi.index')"
                        icon="fa-solid fa-chart-simple"
                        class="w-full px-4 py-2 text-left rounded-md ->r">
                        Data Presensi Siswa
                    </x-nav-link>
                    <x-nav-link :href="route('kenaikan-kelas.index')"
                        :active="request()->routeIs('kenaikan-kelas.index')"
                        icon="fa-solid fa-arrow-trend-up"
                        class="w-full px-4 py-2 text-left rounded-md 
            {{ re">
                        Data Kenaikan Kelas
                    </x-nav-link>
                    @endif
                    @endif
                </div>
            </nav>
        </aside>

        <!-- Konten Utama + Header -->
        <div class="ml-64 flex-1 flex flex-col min-h-screen">

            <!-- Header fixed -->
            <header class="fixed top-0 left-64 right-0  p-6 z-30  " style="background-color: #f3f6ff;">
                @include('layouts.navigation')
                @if (isset($header))
                <div>
                    {{ $header }}
                </div>
                @endif
            </header>


            <!-- Spacer supaya konten main tidak tertutup header -->
            <div class=" h-24">
                </div>

                <!-- Konten utama scrollable -->
                <main class="flex-1 overflow-auto p-10" style="background-color: #f3f6ff;">

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