@extends('layouts.admin')

@section('title', 'daftar alat')

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 px-1 mb-2">

        <div class="bg-white p-4 rounded-2xl border border-slate-200/60 ">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total Alat</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100  flex items-center justify-center">
                    <i class="fas fa-box text-sm text-blue-600 "></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 ">98</h3>
            <p class="text-[11px] text-slate-400">Total</p>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/60 ">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total Kategori Alat</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100  flex items-center justify-center">
                    <i class="fas fa-tags text-sm text-blue-600"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 ">09</h3>
            <p class="text-[11px] text-slate-400">Total</p>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/60 ">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total Qr Code</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-qrcode text-sm text-blue-600"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800">241</h3>
            <p class="text-[11px] text-slate-400">Total</p>
        </div>

        <div class="bg-white p-4 rounded-2xl border border-slate-200/60">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total Stok</p>
                <div class="w-8 h-8 rounded-lg bg-tertiary/100 flex items-center justify-center">
                    <i class="fas fa-cubes text-sm text-primary"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 ">098</h3>
            <p class="text-[11px] text-slate-400">Total</p>
        </div>
    </div>

    <div class="p-4 md:p-2 overflow-x-hidden mt-4 min-h-screen">
        <div class="bg-white text-gray-900  p-4 rounded-lg shadow-md ">
            <h2 class="text-center text-xl font-bold mb-4 text-gray-800">Data Alat Management</h2>
            <div class="flex flex-wrap justify-end gap-2">
                <a href="{{ route('admin.data-buku.create') }}">
                    <button
                        class="px-6 py-3 bg-linear-to-r cursor-pointer from-blue-600 to-blue-700 text-white rounded-xl font-semibold shadow-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-300">
                        <i class="fas fa-plus mr-2"></i>
                        Create Data
                    </button>
                </a>
            </div>


            <div class="overflow-x-auto mt-4">
                <table id="alatTable" class="w-full border border-gray-300 text-xs md:text-sm ">
                    <thead class="bg-gray-200 text-gray-800 ">
                        <tr>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Foto</th>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Judul Buku</th>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Penulis</th>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Stok</th>
                            <th class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Buku as $row)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">
                                    @if ($row->foto_buku)
                                        <img src="{{ Storage::url($row->foto_buku) }}" alt="Foto Alat"
                                            class="w-16 h-16 object-cover rounded-md">
                                    @else
                                        <img src="{{ 'assets/no-image.png' }}" alt="No Image"
                                            class="w-16 h-16 object-cover rounded-md">
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">{{ $row->judul_buku }}</td>

                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">{{ $row->penulis }}</td>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2">{{ $row->stok }}</td>
                                <td class="border border-gray-300 px-2 py-1 md:px-4 md:py-2 text-center">
                                    <div class="flex justify-center space-x-1 md:space-x-2">
                                        <a href="{{ route('admin.data-buku.edit', $row->id) }}"
                                            class="text-amber-600 hover:text-white bg-amber-50 hover:bg-amber-500 p-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110">
                                            <i class="fas fa-edit"></i> <span class="hidden sm:inline">Edit</span>
                                        </a>

                                        <a href="{{ route('admin.data-buku.show', $row->id) }}"
                                            class="text-green-600 hover:text-white bg-green-50 hover:bg-green-500  p-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110">
                                            <i class="fas fa-eye"></i> <span class="hidden sm:inline">Show</span>
                                        </a>

                                        <form action="{{ route('admin.data-buku.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn-delete text-red-600 hover:text-white bg-red-50 hover:bg-red-600 p-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer transform hover:scale-110"
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
                    $('#alatTable').DataTable({
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
