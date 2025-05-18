<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Kelas
            </h2>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-md rounded-2xl">
            <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <x-input label="Nama Kelas" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required />
                </div>

                <div class="mb-4">
                    <x-input label="Tingkatan" name="tingkatan" value="{{ old('tingkatan', $kelas->tingkatan) }}" required />
                </div>

                <div class="mb-4">
                    <label for="wali_kelas_id" class="block text-sm font-medium text-gray-700">Wali Kelas</label>
                    <select name="wali_kelas_id" id="wali_kelas_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Wali Kelas</option>
                        @foreach($guru as $g)
                        <option value="{{ $g->id }}" {{ $g->id == old('wali_kelas_id', $kelas->wali_kelas_id) ? 'selected' : '' }}>
                            {{ $g->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end mt-8">
                    <a href="{{ route('kelas.index') }}"
                        class="inline-block px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg mr-3 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-block px-6 py-2.5 text-white bg-blue-600 hover:bg-blue-700 font-medium text-sm rounded-lg shadow-md transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>