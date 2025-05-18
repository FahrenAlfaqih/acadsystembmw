<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p>Selamat datang, {{ auth()->user()->name }}</p>

            @if($jadwal->isEmpty())
            <p class="mt-2 text-gray-500">Data Jadwal Pelajaran tidak tersedia.</p>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach ($jadwal as $item)
                <div class="bg-white shadow-lg hover:shadow-2xl transition-shadow rounded-2xl overflow-hidden border border-gray-200 group">
                        <div class="p-5">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 hover:text-blue-600">{{ $item->mapel->nama_mapel }}</h3>
                            <p class="text-sm text-gray-500 mb-1"><i class="fas fa-chalkboard mr-2"></i> Kelas: <span class="font-medium">{{ $item->kelas->nama_kelas }}</span></p>
                            <p class="text-sm text-gray-500 mb-1"><i class="fas fa-calendar-day mr-2"></i> Hari: <span class="font-medium">{{ $item->hari }}</span></p>
                            <p class="text-sm text-gray-500 mb-1"><i class="fas fa-clock mr-2"></i> Jam: <span class="font-medium">{{ $item->jam_mulai }} - {{ $item->jam_selesai }}</span></p>
                            <p class="text-sm text-gray-500 mb-2">
                                <i class="fas fa-layer-group mr-2"></i>
                                <span class="font-medium">{{ $item->semester->nama }}</span>
                            </p>
                        </div>

                    <div class="px-5 pb-5 flex flex-wrap gap-3">
                        <a href="{{ route('presensi.create', ['kelas_id' => $item->kelas->id, 'mapel_id' => $item->mapel->id, 'semester_id' => $item->semester->id]) }}"
                            class="flex-1 text-center bg-indigo-100 text-indigo-800 px-5 py-3 text-sm font-medium rounded-xl hover:bg-indigo-200 hover:text-indigo-900 transition-all transform hover:scale-105 shadow-sm">
                            Isi Presensi
                        </a>

                        <a href="{{ route('rekap.presensi', ['kelas_id' => $item->kelas->id, 'semester_id' => $item->semester->id, 'mapel_id' => $item->mapel->id]) }}"
                            class="flex-1 text-center bg-cyan-100 text-cyan-800 px-5 py-3 text-sm font-medium rounded-xl hover:bg-cyan-200 hover:text-cyan-900 transition-all transform hover:scale-105 shadow-sm">
                            Rekap Presensi
                        </a>

                        <a href="{{ route('nilai.create', ['kelas_id' => $item->kelas->id, 'mapel_id' => $item->mapel->id, 'semester_id' => $item->semester->id]) }}"
                            class="flex-1 text-center bg-violet-100 text-violet-800 px-5 py-3 text-sm font-medium rounded-xl hover:bg-violet-200 hover:text-violet-900 transition-all transform hover:scale-105 shadow-sm">
                            Isi Nilai
                        </a>

                        <a href="{{ route('rekap.nilai', ['kelas_id' => $item->kelas->id, 'semester_id' => $item->semester->id, 'mapel_id' => $item->mapel->id]) }}"
                            class="flex-1 text-center bg-emerald-100 text-emerald-800 px-5 py-3 text-sm font-medium rounded-xl hover:bg-emerald-200 hover:text-emerald-900 transition-all transform hover:scale-105 shadow-sm">
                            Rekap Nilai
                        </a>
                    </div>


                </div>
                @endforeach
            </div>

            @endif
        </div>
    </div>
</x-app-layout>