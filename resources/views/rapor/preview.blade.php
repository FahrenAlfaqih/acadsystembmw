<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Preview Rapor Kelas {{ $kelas->nama_kelas }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-xl">
            {{-- Container tombol dengan flex --}}
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 space-y-3 sm:space-y-0">
                <a href="{{ route('rapor.index') }}"
                    class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                    Kembali ke daftar kelas
                </a>

                <a href="{{ route('rapor.cetakPdf', $kelas->id) }}" target="_blank"
                    class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                    📄 Download Semua Rapor (PDF)
                </a>
            </div>

            @if($siswa->isEmpty())
                <p class="text-gray-500">Tidak ada siswa di kelas ini.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-left border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600">
                                <th class="border border-gray-300 py-3 px-4 text-sm font-medium">Nama Siswa</th>
                                <th class="border border-gray-300 py-3 px-4 text-sm font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($siswa as $item)
                            <tr class="border-b border-gray-300 hover:bg-gray-50 transition duration-300">
                                <td class="border border-gray-300 py-3 px-4 text-sm">{{ $item->nama }}</td>
                                <td class="border border-gray-300 py-3 px-4 text-sm space-x-2">
                                    <a href="{{ route('rapor.cetak.per_siswa', [$kelas->id, $item->id]) }}" target="_blank"
                                        class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                        Cetak Rapor Siswa
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
