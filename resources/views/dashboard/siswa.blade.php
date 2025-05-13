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
            <p class="text-gray-800 dark:text-black">Selamat datang, {{ auth()->user()->name }}</p>
            <div class="mt-3 overflow-x-auto">
                {{-- ChartJS CDN --}}
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 xl:gap-8 ">
                    <!-- Bar Chart -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 transition duration-300 hover:shadow-xl">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">📊 Rata-rata Nilai</h3>
                        <div class="w-full h-[250px]">
                            <canvas id="barChart" class="w-full h-full"></canvas>
                        </div>
                    </div>

                    <!-- Pie Chart -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 transition duration-300 hover:shadow-xl">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">🥧 Distribusi Nilai</h3>
                        <div class="w-full h-[250px]">
                            <canvas id="pieChart" class="w-full h-full"></canvas>
                        </div>
                    </div>
                </div>





                <div class="mt-10">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Tabel Presensi Siswa</h3>

                    <div class="overflow-x-auto rounded-xl shadow-md">
                        <table class="min-w-full text-sm text-gray-700 bg-white border border-gray-200 rounded-xl overflow-hidden">
                            <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3 border-b text-left">Mata Pelajaran</th>
                                    @foreach ($pertemuanList as $pertemuan)
                                    <th class="px-4 py-3 border-b text-center">P{{ $pertemuan }}</th>
                                    @endforeach
                                    <th class="px-4 py-3 border-b text-center">%</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($mapelList as $mapel)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $mapel->nama_mapel }}
                                    </td>
                                    @foreach ($pertemuanList as $pertemuan)
                                    <td class="px-4 py-3 text-center">
                                        {{ $presensiMap[$mapel->id][$pertemuan] ?? '-' }}
                                    </td>
                                    @endforeach
                                    <td class="px-4 py-3 text-center font-semibold text-blue-600">
                                        {{ $kehadiranPersen[$mapel->id] }}%
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-10">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Tabel Nilai Siswa</h3>

                    <div class="overflow-x-auto shadow-md rounded-xl">
                        <table class="min-w-full text-sm text-gray-700 bg-white border border-gray-200 rounded-xl overflow-hidden">
                            <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                                <tr>
                                    <th class="py-3 px-4 text-sm font-medium">Mata Pelajaran</th>
                                    <th class="py-3 px-4 text-sm font-medium">Nilai Harian</th>
                                    <th class="py-3 px-4 text-sm font-medium">UTS</th>
                                    <th class="py-3 px-4 text-sm font-medium">UAS</th>
                                    <th class="py-3 px-4 text-sm font-medium">Rata-rata</th>
                                    <th class="py-3 px-4 text-sm font-medium">Grade</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($mapelList as $mapel)
                                @php
                                $nilai = $nilaiList->firstWhere('mapel_id', $mapel->id);
                                @endphp
                                <tr class="border-b hover:bg-gray-50 transition duration-300">
                                    <td class="py-3 px-4 text-sm">{{ $mapel->nama_mapel }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $nilai->nilai_harian ?? '-' }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $nilai->nilai_uts ?? '-' }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $nilai->nilai_uas ?? '-' }}</td>
                                    <td class="py-3 px-4 text-sm font-semibold text-blue-600">
                                        {{ isset($nilai->rata_rata) ? number_format($nilai->rata_rata, 2) : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-sm font-bold text-white">
                                        @if ($nilai)
                                        <span class="@switch($nilai->grade)
                                                @case('A') bg-green-500 @break
                                                @case('AB') bg-green-700 @break
                                                @case('B') bg-blue-500 @break
                                                @case('C') bg-yellow-500 text-gray-800 @break
                                                @case('D') bg-orange-500 @break
                                                @case('E') bg-red-500 @break
                                                @default bg-gray-400
                                            @endswitch px-3 py-1 rounded-full text-xs inline-block">
                                            {{ $nilai->grade }}
                                        </span>
                                        @else
                                        <span class="bg-gray-400 px-2 py-1 rounded">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>




            </div>
        </div>
    </div>
    <script>
        const labels = @json($nilaiLabels);
        const dataNilai = @json($nilaiRataRata);

        // Bar Chart
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nilai Rata-rata',
                    data: dataNilai,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Nilai Rata-rata',
                    data: dataNilai,
                    backgroundColor: [
                        '#4caf50',
                        '#2196f3',
                        '#ff9800',
                        '#f44336',
                        '#9c27b0',
                        '#3f51b5'
                    ]
                }]
            },
            options: {
                responsive: true,
            }
        });
    </script>
</x-app-layout>