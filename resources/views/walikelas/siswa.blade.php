<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar Siswa {{ $kelas->nama_kelas}}
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg mb-6">
            <h3 class="font-semibold text-lg text-gray-800 mb-4">Cari Siswa</h3>
            <form method="GET" class="flex space-x-2 max-w-md">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari berdasarkan nama atau NISN..."
                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />

                <button type="submit"
                    class="text-sm px-4 py-2 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 transition flex items-center">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>

                <a href="{{ route('wali-kelas-siswa.index') }}"
                    class="text-sm px-4 py-2 border border-blue-500 text-blue-600 rounded-lg hover:bg-blue-50 transition flex items-center">
                    <i class="fas fa-rotate-right mr-1"></i> Reload
                </a>
            </form>
        </div>



        <div class="bg-white p-6 shadow-md rounded-lg">
            @if($siswa->isEmpty())
            <p class="text-gray-500">Tidak ada siswa di kelas ini.</p>
            @else

            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left border-separate border-spacing-0 mt-4">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="py-3 px-4 text-sm font-medium">No</th>
                            <th class="py-3 px-4 text-sm font-medium">Nama</th>
                            <th class="py-3 px-4 text-sm font-medium">Email</th>
                            <th class="py-3 px-4 text-sm font-medium">NISN</th>
                            <th class="py-3 px-4 text-sm font-medium">Kelas</th>
                            <th class="py-3 px-4 text-sm font-medium">Alamat</th>
                            <th class="py-3 px-4 text-sm font-medium">No Telepon</th>
                            <th class="py-3 px-4 text-sm font-medium">Orang tua</th>
                            <th class="py-3 px-4 text-sm font-medium">Status</th>
                            <th class="py-3 px-4 text-sm font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswa as $key => $s)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="py-3 px-4 text-sm">{{ $key + 1 }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->nama }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->email }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->nisn }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->alamat }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->no_telepon }}</td>
                            <td class="py-3 px-4 text-sm">{{ $s->orangtua }}</td>
                            <td class="py-3 px-4 text-sm">
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $s->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm space-x-2">
                                <a href="{{ route('siswa.show', $s->id) }}" class="inline-block text-sm text-blue-600 hover:underline">
                                    Detail
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