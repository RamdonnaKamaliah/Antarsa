@extends('layouts.admin')

@section('title', 'Detail Data Alat')

@section('content')
    <div class="p-6">

        {{-- Back --}}

        <a href="{{ route('admin.data-alat.index') }}"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 dark:text-slate-400 dark:hover:text-white mb-5 transition">
            <i class="fas fa-arrow-left text-xs"></i>
            Kembali ke Daftar
        </a>
        <div class="w-full mx-auto bg-white dark:bg-slate-800 rounded-2xl shadow overflow-hidden">

            {{-- Header --}}
            <div class="bg-teal-500 px-6 py-4">
                <h1 class="text-white font-bold text-lg">Detail Data Alat</h1>
                <p class="text-teal-100 text-xs mt-0.5">Informasi lengkap perangkat</p>
            </div>

            <div class="p-6 space-y-5">

                {{-- Foto + QR sejajar --}}
                <div class="flex gap-4">

                    {{-- Foto --}}
                    <div
                        class="w-40 h-40 shrink-0 rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                        @if ($alat->foto_alat)
                            <img src="{{ asset('storage/' . $alat->foto_alat) }}" alt="Foto Alat"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center gap-1 text-gray-400">
                                <i class="fas fa-image text-2xl"></i>
                                <span class="text-xs">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>

                    {{-- QR --}}
                    <div
                        class="flex-1 flex flex-col items-center justify-center gap-2 rounded-xl border border-gray-100 dark:border-slate-600 bg-gray-50 dark:bg-slate-700 p-4">
                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">QR Code</span>
                        @if ($alat->qr_code)
                            <img src="{{ asset('storage/qrcode/' . $alat->qr_code) }}" alt="QR Code"
                                class="w-24 h-24 object-contain">
                        @else
                            <div
                                class="w-24 h-24 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-slate-600 text-gray-400 text-xs text-center leading-tight">
                                QR tidak<br>tersedia
                            </div>
                        @endif
                    </div>

                </div>

                <hr class="border-gray-100 dark:border-slate-700">

                {{-- Info --}}
                <div class="grid grid-cols-3 gap-3">

                    <div class="col-span-3 bg-gray-50 dark:bg-slate-700 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-0.5">Nama Alat</p>
                        <p class="font-semibold text-gray-800 dark:text-white">{{ $alat->nama_alat }}</p>
                    </div>

                    <div class="col-span-2 bg-gray-50 dark:bg-slate-700 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Kategori</p>
                        <span
                            class="inline-block text-xs font-semibold bg-teal-100 text-teal-700 dark:bg-teal-900/40 dark:text-teal-300 px-2.5 py-1 rounded-full">
                            {{ $alat->kategori->nama_kategori ?? '-' }}
                        </span>
                    </div>

                    <div class="bg-gray-50 dark:bg-slate-700 rounded-xl px-4 py-3">
                        <p class="text-xs text-gray-400 mb-1">Stok</p>
                        <span
                            class="inline-block text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 px-2.5 py-1 rounded-full">
                            {{ $alat->stok }} unit
                        </span>
                    </div>

                </div>

                <hr class="border-gray-100 dark:border-slate-700">

                {{-- Actions --}}
                <div class="flex justify-end gap-2">
                    <a href="{{ route('admin.data-alat.index') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 dark:bg-slate-700 dark:hover:bg-slate-600 dark:text-slate-300 transition">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali
                    </a>
                    <a href="{{ route('admin.data-alat.edit', $alat->id) }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg bg-yellow-400 hover:bg-yellow-500 text-white transition">
                        <i class="fas fa-pen mr-1"></i> Edit
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
