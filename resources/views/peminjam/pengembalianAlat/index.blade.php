@extends('layouts.peminjam')

@section('title', 'daftar pengembalian alat')

@section('content')



    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 px-1 mb-2">

        <div class="bg-white bg-slate-800 p-4 rounded-2xl border border-slate-200/60 border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjamans</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-white">54</h3>
            <p class="text-[11px] text-slate-400">peminjaman Count</p>
        </div>

        <div class="bg-white bg-slate-800 p-4 rounded-2xl border border-slate-200/60 border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjamans</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-white">54</h3>
            <p class="text-[11px] text-slate-400">peminjaman Count</p>
        </div>

        <div class="bg-white bg-slate-800 p-4 rounded-2xl border border-slate-200/60 border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjamans</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-white">54</h3>
            <p class="text-[11px] text-slate-400">peminjaman Count</p>
        </div>

        <div class="bg-white bg-slate-800 p-4 rounded-2xl border border-slate-200/60 border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjamans</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-white">54</h3>
            <p class="text-[11px] text-slate-400">peminjaman Count</p>
        </div>
    </div>


    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Riwayat Pengembalian Alat</h2>
            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Status: Kembali</span>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal" id="pengembalianTable">
                <thead>
                    <tr
                        class="bg-gray-100 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="px-5 py-3">No</th>
                        <th class="px-5 py-3">Tanggal Pinjam</th>
                        <th class="px-5 py-3">Tanggal Kembali</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-5 py-5 text-sm">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-5 py-5 text-sm text-gray-600">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-5 text-sm text-gray-600">
                                {{-- Mengambil data tanggal dari kolom updated_at atau tgl_kembali --}}
                                {{ $item->updated_at->format('d M Y') }}
                            </td>
                            <td class="px-5 py-5 text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative text-xs uppercase">{{ $item->status }}/selesai</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <a href="{{ route('peminjam.pengembalianAlat.show', $item->id) }}"
                                        class="text-green-600 hover:text-white bg-green-50 hover:bg-green-500 bg-green-900/30 hover:bg-green-600 p-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110">
                                        <i class="fas fa-eye"></i> <span class="hidden sm:inline">Show</span>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-500 italic">
                                Belum ada data barang yang sudah dikembalikan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Cek apakah jquery jalan
                console.log("jQuery version: " + $.fn.jquery);

                if (!$.fn.DataTable.isDataTable('#kategoriTable')) {
                    $('#pengembalianTable').DataTable({
                        "responsive": true,
                        "language": {
                            "search": "Cari Kategori:",
                            "lengthMenu": "Tampilkan _MENU_ data",
                        }
                    });
                }
            });
        </script>
    @endpush


@endsection
