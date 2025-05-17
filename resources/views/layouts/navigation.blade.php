<nav x-data="{ open: false }" class="bg-white border-b border-gray-100"> <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('build/assets/img/logo.png') }}" alt="Logo" class="h-9 w-auto">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <p class="mt-2 text-gray-500">SMA Bina Mitra Wahana</p>

                        <!-- @if(auth()->user()->role === 'tatausaha')
                        {{ __('Dashboard Tata Usaha') }}
                        @elseif(auth()->user()->role === 'kepalasekolah')
                        {{ __('Dashboard Kepala Sekolah') }}
                        @elseif(auth()->user()->role === 'guru')
                        {{ __('Dashboard Guru') }}
                        @elseif(auth()->user()->role === 'siswa')
                        {{ __('Dashboard Siswa') }}
                        @else
                        {{ __('Dashboard') }}
                        @endif -->
                    </x-nav-link>
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        @php
                        $foto = null;
                        $role = Auth::user()->role; // atau sesuaikan sesuai struktur role kamu

                        if(auth()->user()->guru) {
                        $foto = auth()->user()->guru->foto;
                        } elseif(auth()->user()->siswa) {
                        $foto = auth()->user()->siswa->foto;
                        } elseif(auth()->user()->kepalaSekolah) {
                        $foto = auth()->user()->kepalaSekolah->foto;
                        }
                        @endphp

                        <button class="text-left flex items-center px-3 py-2 border border-transparent rounded-md text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition duration-150">
                            @if($foto)
                            <img src="{{ asset('storage/foto/' . $foto) }}" alt="Foto Pengguna" class="w-10 h-10 rounded-full object-cover border border-gray-300 me-3">
                            @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 me-3"></div>
                            @endif

                            <div class="flex flex-col justify-end">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-400">{{ ucfirst($role) }}</div>
                            </div>
                        </button>

                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>



            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>