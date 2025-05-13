<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Semester
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <form action="{{ route('semester.update', $semester->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <x-input label="Nama Semester" name="nama" value="{{ old('nama', $semester->nama ?? '') }}" required />
                </div>
                <div class="mb-4">
                    <x-input label="Tahun Ajaran" name="tahun_ajaran" value="{{ $semester->tahun_ajaran }}" required />
                </div>
                <div class="mb-4">
                    <x-select label="Tipe Semester" name="tipe" :options="['Ganjil' => 'Ganjil', 'Genap' => 'Genap']" :value="$semester->tipe" required />
                </div>

                {{-- Checkbox untuk Aktifkan Semester --}}
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="is_aktif" id="is_aktif"
                        class="mr-2 rounded border-gray-300 text-blue-600 shadow-sm focus:ring focus:ring-blue-200"
                        {{ $semester->is_aktif ? 'checked' : '' }}>
                    <label for="is_aktif" class="text-sm text-gray-700">Jadikan semester ini sebagai aktif</label>
                </div>

                <div class="flex justify-end mt-8">
                    <a href="{{ route('semester.index') }}"
                        class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-3 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                        Update Semester
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>