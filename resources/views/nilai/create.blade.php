<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Input Nilai Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-xl">
            <form method="POST" action="{{ route('nilai.store', ['kelas_id' => $kelas_id, 'mapel_id' => $mapel_id, 'semester_id' => $semester_id]) }}">
                @csrf

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-xl shadow-md">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left bg-gray-100 rounded-tl-xl">Nama Siswa</th>
                                <th class="px-4 py-3 text-left bg-gray-100">Ulangan Harian</th>
                                <th class="px-4 py-3 text-left bg-gray-100">Tugas</th>
                                <th class="px-4 py-3 text-left bg-gray-100">Quiz</th>
                                <th class="px-4 py-3 text-left bg-gray-100">UTS</th>
                                <th class="px-4 py-3 text-left bg-gray-100 rounded-tr-xl">UAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswaList as $index => $siswa)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="border-b px-4 py-3 font-medium text-gray-700">
                                    {{ $siswa->nama }}
                                    <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                </td>
                                <td class="border-b px-4 py-3">
                                    <input type="number" name="nilai_ulangan_harian[]" min="0" max="100" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="0" />
                                </td>
                                <td class="border-b px-4 py-3">
                                    <input type="number" name="nilai_tugas[]" min="0" max="100" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="0" />
                                </td>
                                <td class="border-b px-4 py-3">
                                    <input type="number" name="nilai_quiz[]" min="0" max="100" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="0" />
                                </td>
                                <td class="border-b px-4 py-3">
                                    <input type="number" name="nilai_uts[]" min="0" max="100" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="0" />
                                </td>
                                <td class="border-b px-4 py-3">
                                    <input type="number" name="nilai_uas[]" min="0" max="100" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" placeholder="0" />
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end mt-8">
                    <a href="{{ route('guru.dashboard') }}"
                        class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl mr-3 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-xl shadow-md transition">
                        Simpan Nilai
                    </button>
                </div>
            </form>


        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#siswa_id').select2({
                placeholder: "Pilih siswa...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
    @endpush
</x-app-layout>