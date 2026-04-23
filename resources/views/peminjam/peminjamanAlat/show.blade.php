@extends('layouts.peminjam')

@section('title', 'Detail Peminjaman')

@section('content')

    <div class="pt-6 px-4 flex justify-center">
        <div class="w-full bg-white rounded-2xl shadow-lg p-8">

            <div class="mb-6">
                <a href="{{ route('siswa.peminjamAlat') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-2">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
            </div>

            {{-- Judul --}}
            <h2 class="text-2xl font-bold text-center text-white mb-8">
                Detail Peminjaman
            </h2>

            {{-- Info Status --}}
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">
                    ID Peminjaman:
                    <span class="font-bold text-gray-800 ">
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
                <div class="p-4 rounded-xl bg-gray-50">
                    <p class="text-sm text-gray-500">Rencana Ambil</p>
                    <p class="font-bold text-gray-800">
                        {{ $peminjaman->tanggal_pengambilan_rencana }}
                    </p>
                </div>

                <div class="p-4 rounded-xl bg-gray-50">
                    <p class="text-sm text-gray-500">Rencana Kembali</p>
                    <p class="font-bold text-gray-800">
                        {{ $peminjaman->tanggal_pengembalian_rencana }}
                    </p>
                </div>
            </div>

            {{-- Alasan --}}
            @if ($peminjaman->status === 'ditolak')
                <div class="mb-8">
                    <p class="text-sm text-gray-500 mb-2">
                        Alasan / Catatan
                    </p>
                    <div class="p-4 rounded-xl bg-gray-100 text-gray-800">
                        {{ $peminjaman->alasan_penolakan }}
                    </div>
                </div>
            @endif

            {{-- List Alat --}}
            <h3 class="text-lg font-bold text-gray-800 mb-4">
                Alat Dipinjam
            </h3>

            <div class="space-y-4">
                <div class="flex justify-between items-center p-4 rounded-xl bg-gray-50 ">
                    {{ $peminjaman->buku_id }}
                </div>
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
