@extends('layouts.admin')

@section('title', 'edit data alat')

@section('content')
    <div class="pt-1">
        <div class="flex justify-center items-center min-h-[80vh] py-6 px-4">
            <div class="w-full max-w-5xl min-h-100 bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <a href="{{ route('admin.data-buku.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                </div>


                <!-- Judul -->
                <h2 class="text-center text-2xl font-bold text-gray-800 mb-6 dark:text-white">Edit Data Alat</h2>

                <!-- Form -->
                <form action="{{ route('admin.data-buku.update', $Buku->id) }}" method="POST" id="editForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="judul_buku" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">Judul
                            Buku</label>
                        <input type="text" id="judul_buku" name="judul_buku" placeholder="Input judul buku"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition"
                            value="{{ old('judul_buku', $Buku->judul_buku) }}">
                        @error('judul_buku')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="penulis" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">Penulis
                            Buku</label>
                        <input type="text" id="penulis" name="penulis" placeholder="Input judul buku"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition"
                            value="{{ old('penulis', $Buku->penulis) }}">
                        @error('penulis')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">

                        <label for="kategori_id" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">Kategori
                            Alat</label>
                        <select id="kategori_id" name="kategori_id"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                            <option value="{{ old('kategori_id') }}">Pilih Kategori</option>
                            @foreach ($kategori as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ old('kategori_id', $Buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="mb-4">
                        <label for="stok" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">Stok
                            Alat</label>
                        <input type="number" id="stok" name="stok" placeholder="Input stok Alat"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition"
                            value="{{ old('stok', $Buku->stok) }}">
                        @error('stok')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="foto_buku" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Foto Buku</label>
                        @if ($Buku->foto_buku)
                            <div class="mb-2">
                                <p class="text-gray-500 text-sm mb-2">Foto buku saat ini</p>
                                <img src="{{ asset('storage/' . $Buku->foto_buku) }}" alt="foto_buku"
                                    class="aspect-4/3 object-cover rounded-lg border-gray-200 border-2 border-dashed">
                            </div>
                        @endif

                        <p class="text-gray-500 text-sm mb-2">Pilih untuk mengganti foto</p>
                        <input type="file" id="foto_buku" name="foto_buku"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition">
                        @error('foto_buku')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-primary text-white py-3 rounded-lg hover:bg-secondary transition cursor-pointer ">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
