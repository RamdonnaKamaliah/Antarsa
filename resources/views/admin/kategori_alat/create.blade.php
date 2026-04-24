@extends('layouts.admin')

@section('title', 'create data kategori')

@section('content')

    <div class="pt-1">
        <div class="flex justify-center items-center min-h-[80vh] py-6 px-4">
            <div class="w-full max-w-5xl min-h-100 bg-white p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <a href="{{ route('admin.kategori-alat.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                </div>


                <!-- Judul -->
                <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Create Data Kategori</h2>

                <!-- Form -->
                <form action="{{ route('admin.kategori-alat.store') }}" method="POST">
                    @csrf

                    <!-- Input Nama kategori -->
                    <div class="pt-10 mb-4">
                        <label for="name_kategori" class="block text-gray-700 font-semibold mb-2">
                            Nama Kategori<span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="title" name="nama_kategori" placeholder="Input nama kategori"
                            value="{{ old('nama_kategori') }}" @class([
                                'w-full p-3 rounded-lg transition',
                                'border border-red-500 focus:ring-red-400 focus:border-red-500' => $errors->has(
                                    'name_kategori'),
                                'border border-gray-300 focus:ring-blue-400 focus:border-blue-500' => !$errors->has(
                                    'name_kategori'),
                            ])>
                        @error('nama_kategori')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
