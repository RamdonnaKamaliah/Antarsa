@extends('layouts.admin')

@section('title', 'Detail Data Alat')

@section('content')
    <div class="p-6">

        {{-- Back --}}


        <div class="w-full mx-auto bg-white rounded-2xl shadow overflow-hidden">

            {{-- Header --}}
            <div class="bg-teal-500 px-6 py-4 flex items-center gap-4">
                {{-- Tombol Kembali --}}
                <a href="{{ route('admin.data-buku.index') }}"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/20 text-white hover:bg-white/40 transition">
                    <i class="fas fa-arrow-left"></i>
                </a>

                {{-- Judul dan Subjudul --}}
                <div>
                    <h1 class="text-white font-bold text-lg leading-tight">Detail Data Alat</h1>
                    <p class="text-teal-100 text-xs mt-0.5 opacity-90">Informasi lengkap perangkat</p>
                </div>
            </div>
            <div class="p-6 space-y-5">

                {{-- Foto + QR sejajar --}}
                <div class="flex gap-4">

                    {{-- Foto --}}
                    <div class="w-40 h-40 shrink-0 rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                        @if ($Buku->foto_buku)
                            <img src="{{ asset('storage/' . $Buku->foto_buku) }}" alt="Foto Alat"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center gap-1 text-gray-400">
                                <i class="fas fa-image text-2xl"></i>
                                <span class="text-xs">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>



                </div>

                <hr class="border-gray-100">

                {{-- Info --}}
                <div class="grid grid-cols-3 gap-3">

                    <div class="col-span-3 bg-gray-50 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-0.5">Judul Buku</p>
                        <p class="font-semibold text-gray-800">{{ $Buku->judul_buku }}</p>
                    </div>

                    <div class="col-span-3 bg-gray-50 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-0.5">Penulis</p>
                        <p class="font-semibold text-gray-800">{{ $Buku->penulis }}</p>
                    </div>

                    <div class="col-span-2 bg-gray-50 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Kategori</p>
                        <span
                            class="inline-block text-xs font-semibold bg-teal-100 text-teal-700  px-2.5 py-1 rounded-full">
                            {{ $Buku->kategori->nama_kategori ?? '-' }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Stok</p>
                        <span
                            class="inline-block text-xs font-semibold bg-green-100 text-green-700px-2.5 py-1 rounded-full">
                            {{ $Buku->stok }} unit
                        </span>
                    </div>

                </div>

                <hr class="border-gray-100">

                {{-- Actions --}}
                <div class="flex justify-end gap-2">
                    
                    <a href="{{ route('admin.data-buku.edit', $Buku->id) }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg bg-yellow-400 hover:bg-yellow-500 text-white transition">
                        <i class="fas fa-pen mr-1"></i> Edit
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
