@extends('layouts.peminjam')

@section('title', 'daftar peminjaman alat')

@section('content')



    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 px-1 mb-2">

        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjamans</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">54</h3>
            <p class="text-[11px] text-slate-400">peminjaman Count</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjamans</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">54</h3>
            <p class="text-[11px] text-slate-400">peminjaman Count</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjamans</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">54</h3>
            <p class="text-[11px] text-slate-400">peminjaman Count</p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/60 dark:border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjamans</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 dark:text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-white">54</h3>
            <p class="text-[11px] text-slate-400">peminjaman Count</p>
        </div>
    </div>

    <div class="p-4 md:p-2 overflow-x-hidden mt-4 min-h-screen">
        <div class="bg-white dark:bg-slate-800 text-gray-900 dark:text-gray-100 p-4 rounded-lg shadow-md dark:shadow-lg">
            <h2 class="text-center text-xl font-bold mb-4 text-gray-800 dark:text-white">Daftar Peminjaman</h2>


            <div class="overflow-x-auto mt-4">
                <table id="peminjamanTable" class="w-full border border-gray-300 text-xs md:text-sm dark:border-gray-600">
                    <thead class="bg-gray-200 text-gray-800 dark:bg-slate-700 dark:text-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Nama Peminjam</th>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Tanggal</th>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Status</th>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $row)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">
                                    {{ $row->user->name }}
                                </td>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">
                                    {{ \Carbon\Carbon::parse($row->tanggal_pengajuan)->format('d-m-Y') }}</td>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">{{ $row->status }}</td>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2 text-center">
                                    <div class="flex justify-center space-x-1 md:space-x-2">

                                        <a href="{{ route('siswa.peminjaman.show', $row->id) }}"
                                            class="text-green-600 hover:text-white bg-green-50 hover:bg-green-500 dark:bg-green-900/30 dark:hover:bg-green-600 p-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110">
                                            <i class="fas fa-eye"></i> <span class="hidden sm:inline">Show</span>
                                        </a>

                                        <form action="{{ route('admin.peminjaman.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn-delete text-red-600 hover:text-white bg-red-50 hover:bg-red-500 
    dark:bg-red-900/30 dark:hover:bg-red-600 p-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer transform hover:scale-110"
                                                data-title="{{ $row->nama_alat }}">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>

                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Cek apakah jquery jalan
                console.log("jQuery version: " + $.fn.jquery);

                if (!$.fn.DataTable.isDataTable('#kategoriTable')) {
                    $('#peminjamanTable').DataTable({
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
