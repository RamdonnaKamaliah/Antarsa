@extends('layouts.peminjam')
@section('title', 'Dashboard Saya')

@section('content')

    {{-- 1. Card Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Pinjaman Aktif --}}
        <div
            class="bg-white p-6 rounded-2xl border-b-4 hover:shadow-lg hover:shadow-gray-400 none hover:-translate-y-0.5 transition-all duration-300   border-blue-600 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
                <i class="fas fa-book-reader"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Pinjaman Aktif</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['pinjaman_aktif'] }}</h3>
            </div>
        </div>

        {{-- Pending --}}
        <div
            class="bg-white p-6 rounded-2xl border-b-4 hover:shadow-lg hover:shadow-gray-400 hover:-translate-y-0.5 transition-all duration-300 border-amber-600 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Menunggu Approval</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_pending'] }}</h3>
            </div>
        </div>

        {{-- Selesai --}}
        <div
            class="bg-white p-6 rounded-2xl border-b-4 border-green-600 shadow-sm flex items-center gap-4 hover:shadow-lg hover:shadow-gray-400 hover:-translate-y-0.5 transition-all duration-300">
            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center text-xl">
                <i class="fas fa-check-double"></i>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Selesai</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total_kembali'] }}</h3>
            </div>
        </div>
    </div>

    {{-- 4. Rekomendasi Buku (Random 4) --}}
    <div class="mb-10 bg-white p-8 rounded-2xl">
        <div class="flex flex-col mb-6">
            <div class="flex items-center justify-start gap-2">
                <i class="fas fa-book-reader text-primary text-lg"></i>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">
                    Rekomendasi Buku Untukmu
                </h2>
            </div>

            {{-- Baris Deskripsi --}}
            <p class="text-sm text-slate-500 mt-1">
                Booking & pinjam buku di sini
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($rekomendasiBuku as $buku)
                <div
                    class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group hover:-translate-y-2 transition-all duration-300">
                    <div class="h-52 bg-slate-100 relative overflow-hidden">
                        @if ($buku->foto_buku)
                            <img src="{{ asset('storage/' . $buku->foto_buku) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400">
                                <i class="fa-solid fa-image text-3xl"></i>
                            </div>
                        @endif
                        <div
                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <a href="{{ route('siswa.data-alat.show', $buku->id) }}"
                                class="bg-white text-slate-900 px-4 py-2 rounded-full text-xs font-bold shadow-xl">Detail
                                Buku</a>
                        </div>
                    </div>

                    <div class="p-5">
                        <span
                            class="text-[9px] bg-primary/10 text-primary px-2 py-0.5 rounded-md font-bold uppercase tracking-tighter">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                        <h3
                            class="font-bold text-slate-800 truncate mt-2 group-hover:text-primary transition-colors">
                            {{ $buku->judul_buku }}</h3>
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-slate-50">
                            <span class="text-[12px] text-slate-400 font-medium italic">Oleh:
                                {{ Str::limit($buku->penulis, 12) }}</span>
                            <span class="text-[10px] font-bold {{ $buku->stok > 0 ? 'text-green-500' : 'text-red-500' }}">
                                {{ $buku->stok }} Tersedia
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 2. Alert Deadline --}}
    @if ($pinjamanMendekatiDeadline->count() > 0)
        <div class="bg-amber-50 border-l-4 border-amber-400 p-4 mb-8 rounded-r-2xl flex items-center gap-4 animate-pulse">
            <div class="bg-amber-400 text-white w-10 h-10 rounded-full flex items-center justify-center shrink-0">
                <i class="fas fa-bell"></i>
            </div>
            <div>
                <p class="text-amber-900 font-bold text-sm">Hai Donna, Ada Deadline!</p>
                <p class="text-amber-700 text-xs">Segera kembalikan {{ $pinjamanMendekatiDeadline->count() }} buku sebelum
                    jatuh tempo ya.</p>
            </div>
        </div>
    @endif

    {{-- 3. Tabel Pinjaman Aktif --}}
    <div class="bg-white  rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-10">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center">
            <h2 class="font-bold text-slate-800  flex items-center gap-2">
                <i class="fa-solid fa-list-check text-primary"></i> Buku yang Kamu Bawa
            </h2>
            <a href="{{ route('siswa.peminjamAlat') }}" class="text-primary text-xs font-bold hover:underline">LIHAT
                SEMUA</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50  text-slate-400 text-[10px] uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Judul Buku</th>
                        <th class="px-6 py-4">Tgl Pinjam</th>
                        <th class="px-6 py-4">Batas Kembali</th>
                        <th class="px-6 py-4 text-center">Status Sisa Waktu</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($pinjamanAktif as $pinjam)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-semibold text-slate-700 ">
                                {{ $pinjam->buku->judul }}</td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ \Carbon\Carbon::parse($pinjam->tgl_kembali_rencana)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                @php $diff = \Carbon\Carbon::now()->diffInDays($pinjam->tgl_kembali_rencana, false); @endphp
                                @if ($diff < 0)
                                    <span
                                        class="px-3 py-1 bg-red-100 text-red-600 rounded-lg text-[10px] font-black uppercase">Terlambat
                                        {{ abs($diff) }} Hari</span>
                                @else
                                    <span
                                        class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase">{{ $diff }}
                                        Hari Lagi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <img src="https://illustrations.popsy.co/gray/reading-book.svg"
                                    class="w-32 mx-auto mb-4 opacity-50">
                                <p class="text-slate-400 text-sm">Belum ada buku di tanganmu. <a
                                        href="{{ route('siswa.data-alat.index') }}"
                                        class="text-primary font-bold underline">Cari Buku?</a></p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@endsection
