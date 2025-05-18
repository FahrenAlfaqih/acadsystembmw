<x-app-layout>
    <x-slot name="header">

    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 shadow rounded-2xl">
                <p>Selamat datang, {{ auth()->user()->name }}</p>
                <p class="text-sm text-gray-600">Berikut adalah data anak anda: <strong>{{ $siswa->nama }} kelas {{ $siswa->kelas->nama_kelas}}</strong></p>
            </div>
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
                    <div class="w-full h-[250px] flex justify-center items-center">
                        <canvas id="pieChart" class="max-w-[250px] max-h-[250px]"></canvas>
                    </div>

                </div>
            </div>

            <!-- Line Chart Kehadiran -->
            <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 mt-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">📈 Kehadiran per Pertemuan</h3>
                <canvas id="lineChart" class="w-full h-[150px]"></canvas>
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

        const pertemuanLabels = @json($pertemuanList);
        const mapelList = @json($mapelList);
        const presensiMap = @json($presensiMap);
        const kehadiranPersen = @json($kehadiranPersen);

        // Data untuk Line Chart (Kehadiran per pertemuan per mapel)
        const datasetsLine = mapelList.map(mapel => {
            const data = pertemuanLabels.map(pertemuan => {
                const status = presensiMap[mapel.id]?.[pertemuan];
                return status === 'Hadir' ? 1 : 0;
            });
            return {
                label: mapel.nama_mapel,
                data,
                fill: false,
                borderColor: `hsl(${Math.floor(Math.random() * 360)}, 70%, 50%)`, // random warna
                tension: 0.1
            };
        });


        const ctxLine = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: pertemuanLabels,
                datasets: datasetsLine
            },
            options: {
                scales: {
                    y: {
                        min: 0,
                        max: 1,
                        ticks: {
                            callback: v => v === 1 ? 'Hadir' : 'Tidak'
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>