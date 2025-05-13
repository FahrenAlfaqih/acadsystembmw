<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Mata Pelajaran
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                <h3 class="font-semibold text-lg text-gray-800">
                    Daftar Mapel
                </h3>
                <a href="{{ route('mapel.create') }}" class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                    Tambah Mapel
                </a>
            </div>

            @if($mapels->isEmpty())
                <p class="mt-2 text-gray-500">Data mapel tidak tersedia.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600">
                                <th class="py-3 px-4 text-sm font-medium">Kode Mapel</th>
                                <th class="py-3 px-4 text-sm font-medium">Nama Mapel</th>
                                <th class="py-3 px-4 text-sm font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mapels as $mapel)
                                <tr class="border-b hover:bg-gray-50 transition duration-300">
                                    <td class="py-3 px-4 text-sm">{{ $mapel->kode_mapel }}</td>
                                    <td class="py-3 px-4 text-sm">{{ $mapel->nama_mapel }}</td>
                                    <td class="py-3 px-4 text-sm text-center space-x-2">
                                        <a href="{{ route('mapel.edit', $mapel->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('mapel.destroy', $mapel->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <!-- <button type="submit" class="text-red-600 hover:underline">Hapus</button> -->
                                        </form>
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
