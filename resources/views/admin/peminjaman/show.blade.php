@extends('layouts.admin')

@section('title', 'detail peminjaman')

@section('content')

    <div class="pt-6 px-4 flex justify-center">
        <div class="w-full bg-white bg-slate-800 rounded-2xl shadow-lg p-8">

            <div class="mb-6">
                <a href="{{ route('admin.peminjaman.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
            </div>

            {{-- Judul --}}
            <h2 class="text-2xl font-bold text-center text-gray-800 text-white mb-8">
                Detail Peminjaman
            </h2>

            {{-- Info Status --}}
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600 text-gray-300">
                    ID Peminjaman:
                    <span class="font-bold text-gray-800 text-white">
                        #{{ $peminjaman->id }}
                    </span>
                </p>

                <span
                    class="px-4 py-2 rounded-xl text-sm font-semibold
                @if ($peminjaman->status == 'pending') bg-yellow-100 text-yellow-700
                @elseif($peminjaman->status == 'disetujui') bg-green-100 text-green-700
                @elseif($peminjaman->status == 'ditolak') bg-red-100 text-red-700 @endif">
                    {{ strtoupper($peminjaman->status) }}
                </span>
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="p-4 rounded-xl bg-gray-50 bg-slate-700">
                    <p class="text-sm text-gray-500 text-gray-300">Rencana Ambil</p>
                    <p class="font-bold text-gray-800 text-white">
                        {{ $peminjaman->tanggal_pengambilan_rencana }}
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-gray-50 bg-slate-700">
                    <p class="text-sm text-gray-500 text-gray-300">Rencana Kembali</p>
                    <p class="font-bold text-gray-800 text-white">
                        {{ $peminjaman->tanggal_pengembalian_rencana }}
                    </p>
                </div>
            </div>

            {{-- Alasan --}}
            <div class="mb-8">
                <p class="text-sm text-gray-500 text-gray-300 mb-2">
                    Alasan / Catatan
                </p>
                <div class="p-4 rounded-xl bg-gray-100 bg-slate-700 text-gray-800 text-white">
                    {{ $peminjaman->alasan_peminjaman }}
                </div>
            </div>

            {{-- List Alat --}}
            <h3 class="text-lg font-bold text-gray-800 text-white mb-4">
                Daftar Alat Dipinjam
            </h3>

            <div class="space-y-4">
                @foreach ($peminjaman->detail as $item)
                    <div class="flex justify-between items-center p-4 rounded-xl bg-gray-50 bg-slate-700">
                        <p class="font-semibold text-gray-800 text-white">
                            {{ $item->alat->nama_alat }}
                        </p>
                        <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 font-bold">
                            {{ $item->jumlah }} pcs
                        </span>
                    </div>
                @endforeach
            </div>

            {{-- Jika Pending --}}
            @if ($peminjaman->status == 'pending')
                <div class="mt-10 text-center">
                    <p class="text-yellow-600 font-semibold">
                        Menunggu persetujuan petugas...
                    </p>
                </div>
            @endif

        </div>
    </div>


@endsection
