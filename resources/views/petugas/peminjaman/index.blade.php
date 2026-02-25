@extends('layouts.petugas')

@section('title', 'Approve Peminjaman')

@section('content')

    <h1 class="text-2xl font-bold mb-6">Daftar Pengajuan Peminjaman</h1>

    <div class="space-y-5">

        @foreach ($peminjaman as $p)
            <div class="bg-white rounded-2xl shadow p-5 flex justify-between items-center">

                {{-- Info --}}
                <div>
                    <h2 class="text-lg font-bold">
                        {{ $p->user->name }}
                    </h2>
                    <h2 class="text-lg font-bold">
                        {{ $p->user->name }}
                    </h2>

                    <p class="text-sm text-gray-500">
                        Tanggal: {{ $p->tanggal_pengambilan_rencana }}
                    </p>
                   

                    

                    <span
                        class="px-3 py-1 text-xs rounded-full
                    @if ($p->status == 'pending') bg-yellow-100 text-yellow-700
                    @elseif($p->status == 'disetujui') bg-green-100 text-green-700
                    @elseif($p->status == 'ditolak') bg-red-100 text-red-700 @endif
                ">
                        {{ strtoupper($p->status) }}
                    </span>
                </div>

                

                {{-- Tombol Approve/Reject --}}
                @if ($p->status == 'pending')
                    <div class="flex gap-2">

                        {{-- Approve --}}
                        <form action="{{ route('petugas.peminjaman.approve', $p->id) }}" method="POST">
                            @csrf
                            <button class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700">
                                Approve
                            </button>
                        </form>

                        {{-- Reject --}}
                        <button type="button" onclick="openRejectModal({{ $p->id }})"
                            class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700">
                            Tolak
                        </button>

                    </div>
                @elseif ($p->status == 'ditolak')
                    <p class="text-red-500 italic">
                        Peminjaman Ditolak
                    </p>
                @elseif ($p->status == 'disetujui')
                    <button onclick="openScanModal({{ $p->id }})"
                        class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                        Scan QR
                    </button>
                @else
                    <p class="text-gray-500 italic">
                        Alat Sudah diambil
                    </p>
                @endif
    </div>
    @endforeach

    </div>

    {{-- Modal Scan --}}
    <div id="scanModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-96 relative">

            <button onclick="closeScanModal()" class="absolute top-3 right-3 text-gray-500 hover:text-black">
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4 text-center">
                Verifikasi QR Peminjaman
            </h2>

            {{-- Switch --}}
            <div class="flex justify-center gap-2 mb-4">
                <button onclick="showScan()" class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">
                    Scan
                </button>
                <button onclick="showUpload()" class="px-3 py-1 bg-gray-200 rounded-lg text-sm">
                    Upload
                </button>
            </div>

            {{-- SCAN --}}
            <div id="scanSection">
                <div id="reader" class="w-72 mx-auto mb-4"></div>
            </div>

            {{-- UPLOAD --}}
            <div id="uploadSection" class="hidden">
                <form action="{{ route('petugas.peminjaman.scan.verify') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-3">
                    @csrf

                    <input type="hidden" name="peminjaman_id" id="peminjaman_id">
                    <input type="file" name="qr_file" accept="image/*,.svg" class="w-full border rounded-lg p-2 text-sm">

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-xl hover:bg-blue-700">
                        Upload & Verifikasi
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- modal penolakan --}}
    <div id="rejectModal"
        class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 transition-opacity duration-200 opacity-0">

        <div class="bg-white rounded-2xl p-6 w-96 transform transition-all duration-200 scale-95" id="rejectBox">

            <h2 class="text-lg font-bold mb-4">Alasan Penolakan</h2>

            <form id="rejectForm" method="POST">
                @csrf

                <textarea name="alasan_penolakan" class="w-full border rounded-lg p-2 mb-4 focus:ring-2 focus:ring-red-400"
                    placeholder="Masukkan alasan penolakan..." required></textarea>

                <div class="flex justify-end gap-2">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-gray-400 text-white rounded-lg">
                        Batal
                    </button>

                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Konfirmasi Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function openRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            const box = document.getElementById('rejectBox');
            const form = document.getElementById('rejectForm');

            form.action = `/petugas/peminjaman/${id}/reject`;

            modal.classList.remove('hidden');

            setTimeout(() => {
                modal.classList.remove('opacity-0');
                box.classList.remove('scale-95');
                box.classList.add('scale-100');
            }, 10);
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectModal');
            const box = document.getElementById('rejectBox');

            modal.classList.add('opacity-0');
            box.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    </script>




    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrCode;

        function openScanModal(peminjamanId) {
            document.getElementById('scanModal').classList.remove('hidden');
            document.getElementById('scanModal').classList.add('flex');
            document.getElementById('peminjaman_id').value = peminjamanId;
            showScan();
        }

        function showScan() {
            document.getElementById('scanSection').classList.remove('hidden');
            document.getElementById('uploadSection').classList.add('hidden');

            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 220
                },
                qrCodeMessage => {
                    html5QrCode.stop();
                    submitScan(qrCodeMessage);
                }
            );
        }

        function showUpload() {
            if (html5QrCode) html5QrCode.stop();
            document.getElementById('scanSection').classList.add('hidden');
            document.getElementById('uploadSection').classList.remove('hidden');
        }

        function submitScan(result) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('petugas.peminjaman.scan.verify') }}";

            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            const pid = document.createElement('input');
            pid.type = 'hidden';
            pid.name = 'peminjaman_id';
            pid.value = document.getElementById('peminjaman_id').value;

            const qr = document.createElement('input');
            qr.type = 'hidden';
            qr.name = 'qr_result';
            qr.value = result;

            form.appendChild(csrf);
            form.appendChild(pid);
            form.appendChild(qr);

            document.body.appendChild(form);
            form.submit();
        }


        function closeScanModal() {
            if (html5QrCode) html5QrCode.stop();
            document.getElementById('scanModal').classList.add('hidden');
            document.getElementById('scanModal').classList.remove('flex');
        }
    </script>



@endsection
