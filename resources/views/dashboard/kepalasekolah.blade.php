<x-app-layout>
    <x-slot name="header">

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
                    <div class="text-indigo-500">
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
                    <div class="text-indigo-500">
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
                    <div class="text-indigo-500">
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
                    <div class="text-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="ro    und" stroke-width="2"
                                d="M3 10h18M4 6h16M4 14h16M5 18h14" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 xl:gap-8 mt-6">
                <!-- Line Chart Nilai -->
                <div class="bg-white p-6 rounded-2xl shadow-md w-full">
                    <h3 class="text-lg font-semibold text-center mb-4">
                        Perkembangan Nilai Rata-rata per Semester
                    </h3>
                    <canvas id="nilaiChart" class="w-full h-64"></canvas>
                </div>

                <!-- Bar Chart Presensi -->
                <div class="bg-white p-6 rounded-2xl shadow-md w-full">
                    <h3 class="text-lg font-semibold text-center mb-4">
                        Perkembangan Presensi Siswa per Semester
                    </h3>
                    <canvas id="presensiChart" class="w-full h-64"></canvas>
                </div>
            </div>




            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Data dari Controller (pastikan sudah di-passing)
                const semesterLabels = @json($semesterLabels);
                const nilaiRataRata = @json($nilaiRataRata);
                const jumlahPresensi = @json($jumlahPresensi);

                // Line Chart Nilai
                new Chart(document.getElementById('nilaiChart'), {
                    type: 'line',
                    data: {
                        labels: semesterLabels,
                        datasets: [{
                            label: 'Rata-rata Nilai',
                            data: nilaiRataRata,
                            borderColor: '#1d4ed8',
                            backgroundColor: '#3b82f6',
                            fill: false,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: 100
                            }
                        }
                    }
                });

                // Bar Chart Presensi
                new Chart(document.getElementById('presensiChart'), {
                    type: 'bar',
                    data: {
                        labels: semesterLabels,
                        datasets: [{
                            label: 'Jumlah Kehadiran',
                            data: jumlahPresensi,
                            backgroundColor: '#10b981'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: 100
                            }
                        }
                    }
                });
            </script>


            <!-- Pie Chart Guru -->
            <div class="mt-6 overflow-x-auto">
                {{-- ChartJS CDN --}}
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                {{-- Pie Chart Perbandingan Jenis Kelamin Guru--}}
                <div class="bg-white p-6 rounded shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Perbandingan Guru (Laki-laki vs Perempuan)</h3>
                    <canvas id="pieChart"></canvas>

                    {{-- Tampilkan persentase --}}
                    <div class="flex justify-between mt-4">
                        <p><strong>Laki-laki:</strong> <span id="percentageLaki"></span></p>
                        <p><strong>Perempuan:</strong> <span id="percentagePerempuan"></span></p>
                    </div>
                </div>

                <script>
                    const labels = ['Laki-laki', 'Perempuan'];
                    const dataGuru = @json([$jumlahGuruLaki, $jumlahGuruPerempuan]);

                    const totalGuru = dataGuru[0] + dataGuru[1];
                    const percentageLaki = ((dataGuru[0] / totalGuru) * 100).toFixed(2);
                    const percentagePerempuan = ((dataGuru[1] / totalGuru) * 100).toFixed(2);

                    new Chart(document.getElementById('pieChart'), {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Guru',
                                data: dataGuru,
                                backgroundColor: [
                                    '#68d1ff', // Biru untuk laki-laki
                                    '#4319f9' // Ungu untuk perempuan
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                    // Menampilkan persentase dengan benar
                    document.getElementById('percentageLaki').textContent = `${percentageLaki}%`;
                    document.getElementById('percentagePerempuan').textContent = `${percentagePerempuan}%`;
                </script>

                <style>
                    #pieChart {
                        width: 250px !important;
                        height: 250px !important;
                        margin: 0 auto;
                    }
                </style>
            </div>

            <!-- Pie Chart Siswa -->
            <div class="mt-6 overflow-x-auto">
                {{-- ChartJS CDN --}}
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                {{-- Pie Chart --}}
                <div class="bg-white p-6 rounded shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Perbandingan Siswa (Laki-laki vs Perempuan)</h3>
                    <canvas id="pieChartSiswa"></canvas>

                    {{-- Tampilkan persentase --}}
                    <div class="flex justify-between mt-4">
                        <p><strong>Laki-laki:</strong> <span id="percentageSiswaLaki"></span></p>
                        <p><strong>Perempuan:</strong> <span id="percentageSiswaPerempuan"></span></p>
                    </div>
                </div>

                <script>
                    const labelsSiswa = ['Laki-laki', 'Perempuan'];
                    const dataSiswa = @json([$jumlahSiswaLaki, $jumlahSiswaPerempuan]);

                    const totalSiswa = dataSiswa[0] + dataSiswa[1];
                    const percentageSiswaLaki = ((dataSiswa[0] / totalSiswa) * 100).toFixed(2);
                    const percentageSiswaPerempuan = ((dataSiswa[1] / totalSiswa) * 100).toFixed(2);

                    new Chart(document.getElementById('pieChartSiswa'), {
                        type: 'pie',
                        data: {
                            labels: labelsSiswa,
                            datasets: [{
                                label: 'Jumlah Siswa',
                                data: dataSiswa,
                                backgroundColor: [
                                    '#68d1ff', // Biru untuk laki-laki
                                    '#4319f9' // Ungu untuk perempuan
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                    // Menampilkan persentase dengan benar
                    document.getElementById('percentageSiswaLaki').textContent = `${percentageSiswaLaki}%`;
                    document.getElementById('percentageSiswaPerempuan').textContent = `${percentageSiswaPerempuan}%`;
                </script>

                <style>
                    #pieChartSiswa {
                        width: 250px !important;
                        height: 250px !important;
                        margin: 0 auto;
                    }
                </style>
            </div>



        </div>
    </div>
    </div>
</x-app-layout>