<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-900 leading-tight">
                Pilih Kelas Untuk Cetak Rapor
            </h2>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h3 class="font-semibold text-lg text-gray-800 mb-6 border-b pb-2">
                Daftar Kelas
            </h3>

            @if ($kelas->isEmpty())
                <p class="text-gray-500 text-center py-10">Belum ada kelas tersedia.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($kelas as $k)
                        <a href="{{ route('rapor.preview', $k->id) }}"
                            class="block p-5 bg-blue-50 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300
                                   border border-transparent hover:border-blue-400
                                   text-blue-700 font-semibold text-center
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            {{ $k->nama_kelas }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
