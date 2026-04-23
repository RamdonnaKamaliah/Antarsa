@extends('layouts.admin')

@section('title', 'edit data kategori')

@section('content')

    <div class="pt-1">
        <div class="flex justify-center items-center min-h-[80vh] py-6 px-4">
            <div class="w-full max-w-5xl min-h-100 bg-white bg-slate-800 p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <a href="{{ route('admin.kategori-alat.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                </div>

                {{-- @include('components.alert') --}}

                <!-- Judul -->
                <h2 class="text-center text-2xl font-bold text-gray-800 mb-6 text-white">Create Data Kategori</h2>

                <!-- Form -->
                <form action="{{ route('admin.kategori-alat.update', $kategori->id) }}" method="POST" id="editForm">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="nama_kategori" class="block text-gray-700 font-semibold mb-2 text-gray-300">Nama
                            Kategori</label>
                        <input type="text" id="nama_kategori" name="nama_kategori" placeholder="Input nama Kategori"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-500 transition"
                            value="{{ old('nama', $kategori->nama_kategori) }}">
                        @error('nama_kategori')
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
