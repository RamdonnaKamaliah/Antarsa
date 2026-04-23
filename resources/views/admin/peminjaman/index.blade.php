@extends('layouts.admin')

@section('title', 'data peminjaman')

@section('content')

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 px-1 mb-2">

        <div class="bg-white bg-slate-800 p-4 rounded-2xl border border-slate-200/60 border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjaman</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-white">{{ $stats['total_peminjaman'] }}</h3>
            <p class="text-[11px] text-slate-400">Count</p>
        </div>

        <div class="bg-white bg-slate-800 p-4 rounded-2xl border border-slate-200/60 border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total Alat Kembali</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-white">{{ $stats['total_barangKembali'] }}</h3>
            <p class="text-[11px] text-slate-400">Count</p>
        </div>

        <div class="bg-white bg-slate-800 p-4 rounded-2xl border border-slate-200/60 border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total Peminjaman Pending</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-white">{{ $stats['total_barangPending'] }}</h3>
            <p class="text-[11px] text-slate-400">Count</p>
        </div>

        <div class="bg-white bg-slate-800 p-4 rounded-2xl border border-slate-200/60 border-slate-700">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-slate-500">Total peminjaman Ditolak</p>
                <div class="w-8 h-8 rounded-lg bg-blue-100 bg-blue-900/40 flex items-center justify-center">
                    <i class="fas fa-file-alt text-sm text-blue-600 text-blue-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-slate-800 text-white">{{ $stats['total_barangDitolak'] }}</h3>
            <p class="text-[11px] text-slate-400">Count</p>
        </div>
    </div>

    <div class="p-4 md:p-2 overflow-x-hidden mt-4 min-h-screen">
        <div class="bg-white bg-slate-800 text-gray-900 text-gray-100 p-4 rounded-lg shadow-md shadow-lg">
            <h2 class="text-center text-xl font-bold mb-4 text-gray-800 text-white">Daftar Peminjaman</h2>


            <div class="overflow-x-auto mt-4">
                <table id="peminjamanTable" class="w-full border border-gray-300 text-xs md:text-sm border-gray-600">
                    <thead class="bg-gray-200 text-gray-800 bg-slate-700 text-gray-100">
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

                                        @if ($row->status == 'pending')
                                            {{-- Tombol Pemicu Approve --}}
                                            <button type="button"
                                                onclick="openModal('approve', {{ $row->id }}, '{{ $row->user->name }}', '{{ $row->buku->judul }}')"
                                                class="text-blue-600 hover:text-white bg-blue-50 hover:bg-blue-500 p-3 rounded-xl transition-all shadow-md transform hover:scale-110">
                                                <i class="fas fa-check-circle"></i> <span
                                                    class="hidden sm:inline">Approve</span>
                                            </button>

                                            {{-- Tombol Pemicu Reject --}}
                                            <button type="button"
                                                onclick="openModal('reject', {{ $row->id }}, '{{ $row->user->name }}', '{{ $row->buku->judul }}')"
                                                class="text-red-600 hover:text-white bg-red-50 hover:bg-red-500 p-3 rounded-xl transition-all shadow-md transform hover:scale-110">
                                                <i class="fas fa-times-circle"></i> <span
                                                    class="hidden sm:inline">Tolak</span>
                                            </button>
                                        @endif

                                        @if ($row->status == 'disetujui')
                                            {{-- Tombol Pemicu Kembali --}}
                                            <button type="button"
                                                onclick="openModal('kembali', {{ $row->id }}, '{{ $row->user->name }}', '{{ $row->buku->judul }}')"
                                                class="text-orange-600 hover:text-white bg-orange-50 hover:bg-orange-500 p-3 rounded-xl transition-all shadow-md transform hover:scale-110">
                                                <i class="fas fa-undo"></i> <span class="hidden sm:inline">Kembali</span>
                                            </button>
                                        @endif

                                        <a href="{{ route('admin.peminjaman.show', $row->id) }}"
                                            class="text-green-600 hover:text-white bg-green-50 hover:bg-green-500 bg-green-900/30 hover:bg-green-600 p-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110">
                                            <i class="fas fa-eye"></i> <span class="hidden sm:inline">Show</span>
                                        </a>

                                        <form action="{{ route('admin.peminjaman.destroy', $row->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn-delete text-red-600 hover:text-white bg-red-50 hover:bg-red-500 
    bg-red-900/30 hover:bg-red-600 p-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg cursor-pointer transform hover:scale-110"
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

    {{-- POP UP --}}
    <div id="actionModal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/50">
        <div class="bg-white bg-slate-800 rounded-2xl shadow-xl w-full max-w-md p-6 transform transition-all">
            <div class="text-center">
                <div id="modalIconContainer" class="mx-auto flex items-center justify-center h-16 w-16 rounded-full mb-4">
                    <i id="modalIcon" class="fas text-2xl text-white"></i>
                </div>
                <h3 id="modalTitle" class="text-xl font-bold text-gray-800 text-white mb-2"></h3>
                <p class="text-gray-500 text-gray-400 mb-4">
                    <span id="modalText"></span> <br>
                    <span id="targetBuku" class="font-bold text-gray-700 text-gray-200"></span>
                    oleh <span id="targetUser" class="font-bold text-gray-700 text-gray-200"></span>
                </p>
            </div>

            <form id="modalForm" method="POST">
                @csrf
                @method('PATCH')

                {{-- Input Alasan (Hanya muncul jika Reject) --}}
                <div id="alasanContainer" class="hidden mb-4">
                    <label class="block text-left text-sm font-medium text-gray-700 text-gray-300 mb-1">Alasan
                        Penolakan:</label>
                    <textarea name="alasan_penolakan" rows="3"
                        class="w-full rounded-lg border-gray-300 bg-slate-700 text-white focus:ring-red-500"
                        placeholder="Contoh: Buku sedang diperbaiki..."></textarea>
                </div>

                <div class="flex justify-center gap-3 mt-6">
                    <button type="button" onclick="closeModal()"
                        class="px-5 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</button>
                    <button type="submit" id="confirmBtn"
                        class="px-5 py-2 text-white rounded-lg transition shadow-lg font-semibold"></button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('actionModal');
        const form = document.getElementById('modalForm');
        const iconContainer = document.getElementById('modalIconContainer');
        const icon = document.getElementById('modalIcon');
        const title = document.getElementById('modalTitle');
        const text = document.getElementById('modalText');
        const targetBuku = document.getElementById('targetBuku');
        const targetUser = document.getElementById('targetUser');
        const confirmBtn = document.getElementById('confirmBtn');
        const alasanContainer = document.getElementById('alasanContainer');

        function openModal(type, id, userName, bukuTitle) {
            // Reset state
            alasanContainer.classList.add('hidden');
            targetBuku.innerText = bukuTitle;
            targetUser.innerText = userName;

            if (type === 'approve') {
                form.action = `/admin/approve/${id}`;
                title.innerText = "Setujui Peminjaman";
                text.innerText = "Apakah Anda yakin ingin menyetujui peminjaman";
                confirmBtn.innerText = "Ya, Setujui";
                confirmBtn.className = "px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition shadow-lg";
                iconContainer.className =
                    "mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-blue-500 mb-4";
                icon.className = "fas fa-check-circle text-2xl text-white";
            } else if (type === 'reject') {
                form.action = `/admin/reject/${id}`;
                title.innerText = "Tolak Peminjaman";
                text.innerText = "Berikan alasan kenapa Anda menolak peminjaman";
                confirmBtn.innerText = "Ya, Tolak";
                confirmBtn.className = "px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition shadow-lg";
                iconContainer.className = "mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-500 mb-4";
                icon.className = "fas fa-times-circle text-2xl text-white";
                alasanContainer.classList.remove('hidden'); // Munculkan input alasan
            } else if (type === 'kembali') {
                form.action = `/admin/kembali/${id}`;
                title.innerText = "Konfirmasi Pengembalian";
                text.innerText = "Apakah buku sudah benar-benar dikembalikan secara fisik?";
                confirmBtn.innerText = "Ya, Sudah Kembali";
                confirmBtn.className =
                    "px-5 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition shadow-lg";
                iconContainer.className =
                    "mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-orange-500 mb-4";
                icon.className = "fas fa-undo text-2xl text-white";
            }

            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        window.onclick = function(event) {
            if (event.target == modal) closeModal();
        }
    </script>

    <script>
        function rejectPeminjaman(id) {
            let alasan = prompt("Masukkan alasan penolakan:");
            if (alasan != null && alasan != "") {
                document.getElementById('alasan-' + id).value = alasan;
                document.getElementById('reject-form-' + id).submit();
            } else if (alasan != null) {
                alert("Alasan harus diisi ya, Donna!");
            }
        }
    </script>

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
