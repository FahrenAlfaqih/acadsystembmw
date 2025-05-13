<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Kelas
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    Daftar Kelas
                </h3>
                <a href="{{ route('kelas.create') }}" class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">Tambah Kelas</a>
            </div>

            @if($kelas->isEmpty())
            <p class="mt-2 text-gray-500">Data kelas tidak tersedia.</p>
            @else
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">Nama Kelas</th>
                            <th class="py-3 px-4 text-sm font-medium">Tingkatan</th>
                            <th class="py-3 px-4 text-sm font-medium">Wali Kelas</th>
                            <th class="py-3 px-4 text-sm font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas as $k)
                        <tr class="border-b hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $k->nama_kelas }}</td>
                            <td class="py-3 px-4 text-sm">{{ $k->tingkatan }}</td>
                            <td class="py-3 px-4 text-sm">
                                {{ $k->waliKelas ? $k->waliKelas->nama : 'Tidak ada wali kelas' }}
                            </td>
                            <td class="py-3 px-4 text-sm">
                                <a href="{{ route('kelas.edit', $k->id) }}" class="text-blue-600 hover:text-blue-700">Edit</a>
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
