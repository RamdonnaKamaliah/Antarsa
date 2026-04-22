@extends('layouts.admin')

@section('title', 'tambah akun pengguna')

@section('content')

    <div class="pt-1">
        <div class="flex justify-center items-center min-h-[80vh] py-6 px-4">
            <div class="w-full max-w-5xl min-h-100 bg-white dark:bg-slate-800 p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <a href="{{ route('admin.akun-pengguna.index') }}" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-arrow-left text-xl"></i>
                    </a>
                </div>


                <!-- Judul -->
                <h2 class="text-center text-2xl font-bold text-gray-800 mb-6 dark:text-white">Create Data Alat</h2>

                <!-- Form -->
                <form action="{{ route('admin.akun-pengguna.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Input Nama  -->
                    <div class="pt-4 mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Nama<span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="name" name="name" placeholder="Input nama pengguna"
                            value="{{ old('name') }}" @class([
                                'w-full p-3 rounded-lg transition',
                                'border border-red-500 focus:ring-red-400 focus:border-red-500' => $errors->has(
                                    'name'),
                                'border border-gray-300 focus:ring-blue-400 focus:border-blue-500' => !$errors->has(
                                    'name'),
                            ])>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <div class="pt-4 mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            username<span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="username" name="username" placeholder="Input username"
                            value="{{ old('username') }}" @class([
                                'w-full p-3 rounded-lg transition',
                                'border border-red-500 focus:ring-red-400 focus:border-red-500' => $errors->has(
                                    'username'),
                                'border border-gray-300 focus:ring-blue-400 focus:border-blue-500' => !$errors->has(
                                    'username'),
                            ])>
                        @error('username')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    {{-- input email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Email<span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="email" name="email" placeholder="Input email"
                            value="{{ old('email') }}" @class([
                                'w-full p-3 rounded-lg transition',
                                'border border-red-500 focus:ring-red-400 focus:border-red-500' => $errors->has(
                                    'email'),
                                'border border-gray-300 focus:ring-blue-400 focus:border-blue-500' => !$errors->has(
                                    'email'),
                            ])>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- input role --}}
                    {{-- <div class="mb-4">
                        <label for="role" class="block text-gray-700 font-semibold mb-2 dark:text-gray-300">
                            Role<span class="text-red-500">*</span>
                        </label>

                        <select name="role" class="w-full p-3 border rounded-lg">
                            <option value="peminjam">Pemi</option>
                            <option value="petugas">Petugas</option>
                        </select>

                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div> --}}




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
