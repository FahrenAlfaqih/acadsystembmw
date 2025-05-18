<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-gray-800 dark:text-black">Selamat datang, {{ auth()->user()->name }}</p>

            @if(auth()->user()->role === 'tatausaha')

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mt-5">

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


            <!-- <div class="space-y-4">
                <h3 class="font-semibold text-lg text-gray-800">Manajemen Siswa dan Guru</h3>

                <a href="{{ route('siswa.create') }}"
                    class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Tambah Siswa
                </a>
                <a href="{{ route('siswa.index') }}"
                    class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Data Siswa
                </a>

                <a href="{{ route('guru.create') }}"
                    class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Tambah Guru
                </a>
                <a href="{{ route('guru.index') }}"
                    class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                    Data Guru
                </a>
            </div>

            <div class="space-y-4 mt-6">
                <h3 class="font-semibold text-lg text-gray-800">Manajemen Kepala Sekolah</h3>

                <a href="{{ route('kepalasekolah.create') }}"
                    class="inline-block px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
                    Tambah Kepala Sekolah
                </a>
                <a href="{{ route('kepalasekolah.index') }}"
                    class="inline-block px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">
                    Data Kepala Sekolah
                </a>
            </div>

            <div class="space-y-4 mt-6">
                <h3 class="font-semibold text-lg text-gray-800">Manajemen Kelas, Mapel, dan Jadwal</h3>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('kelas.create') }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Tambah Kelas
                    </a>
                    <a href="{{ route('kelas.index') }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Lihat Kelas
                    </a>

                    <a href="{{ route('mapel.create') }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Tambah Mapel
                    </a>
                    <a href="{{ route('mapel.index') }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Lihat Mapel
                    </a>

                    <a href="{{ route('jadwal.create') }}"
                        class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Tambah Jadwal Mapel
                    </a>
                    <a href="{{ route('jadwal.index') }}"
                        class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                        Lihat Jadwal Mapel
                    </a>
                </div>
            </div> -->
            @endif
        </div>
    </div>


</x-app-layout>