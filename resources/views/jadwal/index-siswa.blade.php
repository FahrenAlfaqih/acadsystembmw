<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jadwal Mata Pelajaran Saya
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-2xl">
            <h3 class="font-semibold text-lg text-gray-800 mb-4">
                Jadwal Kelas: {{ $kelasSiswa->nama_kelas ?? '-' }}
            </h3>

            @if($jadwal->isEmpty())
            <p class="text-gray-500">Jadwal belum tersedia.</p>
            @else
            @php
            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($hariList as $hari)
                <div class="border rounded-lg shadow p-4 bg-gray-50">
                    <h4 class="font-semibold text-md mb-2 text-indigo-700">{{ $hari }}</h4>
                    @php
                    $jadwalHari = $jadwal->where('hari', $hari);
                    @endphp

                    @if ($jadwalHari->isEmpty())
                    <p class="text-gray-500 text-sm">Tidak ada jadwal.</p>
                    @else
                    <ul class="text-sm space-y-2">
                        @foreach ($jadwalHari as $item)
                        <li class="border p-2 rounded-md bg-white shadow-sm">
                            <div class="font-semibold text-gray-700">{{ $item->mapel->nama_mapel }}</div>
                            <div class="text-gray-600 text-sm">Jam: {{ $item->jam_mulai }} - {{ $item->jam_selesai }}</div>
                            <div class="text-gray-600 text-sm">Guru: {{ $item->guru->nama }}</div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</x-app-layout>