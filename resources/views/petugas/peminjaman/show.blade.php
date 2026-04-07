@extends('layouts.petugas')

@section('title', 'Detail Peminjaman')

@section('content')

    <div class="w-full p-2 min-h-screen">
        <div class="bg-white shadow-xl rounded-2xl p-8 mx-auto">

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                    <i class="fas fa-arrow-left mr-2 text-lg"></i> Kembali
                </a>
            </div>

            <!-- INFO PEMINJAMAN -->
            <div class="mb-6 border-b pb-4">
                <h2 class="text-xl font-bold mb-2">Informasi Peminjaman</h2>

                <p><span class="font-semibold">Peminjam:</span> {{ $peminjaman->user->name }}</p>
                <p><span class="font-semibold">Tanggal Ambil:</span> {{ $peminjaman->tanggal_pengambilan_rencana }}</p>
                <p><span class="font-semibold">Tanggal Kembali:</span> {{ $peminjaman->tanggal_pengembalian_rencana }}</p>


                <p class="mt-2">
                    <span class="font-semibold">Status:</span>
                    <span
                        class="px-2 py-1 rounded text-xs
                    @if ($peminjaman->status == 'pending') bg-yellow-100 text-yellow-700
                    @elseif($peminjaman->status == 'disetujui') bg-green-100 text-green-700
                    @elseif($peminjaman->status == 'dipinjam') bg-blue-100 text-blue-700
                    @elseif($peminjaman->status == 'dikembalikan') bg-gray-200 text-gray-700
                    @else bg-gray-100 text-gray-700 @endif">
                        {{ strtoupper($peminjaman->status) }}
                    </span>
                </p>
            </div>

            <!-- DAFTAR ALAT -->
            <div>
                <h2 class="text-xl font-bold mb-4">Daftar Alat Dipinjam</h2>

                <div class="space-y-3">
                    @foreach ($peminjaman->detail as $detail)
                        <div class="flex justify-between items-center bg-gray-50 rounded-xl p-4">

                            <!-- Info Alat -->
                            <div>
                                <p class="font-semibold text-lg">
                                    {{ $detail->alat->nama_alat }}
                                </p>

                                <p class="text-sm text-gray-500">
                                    Kode: {{ $detail->alat->kode_barang }} |
                                    Jumlah: {{ $detail->jumlah }}
                                </p>

                                <!-- Status -->
                                @if ($detail->status_pengambilan == 'diambil')
                                    <span class="text-green-600 text-xs font-semibold">
                                        ✔ Sudah diambil
                                    </span>
                                @else
                                    <span class="text-yellow-600 text-xs font-semibold">
                                        Menunggu pengambilan
                                    </span>
                                @endif
                            </div>

                            <!-- Tombol Scan -->

                            <div>
                                {{-- Tombol Scan Pengembalian (Jika sudah diambil) --}}
                                @if ($detail->status_pengambilan == 'diambil')
                                    <button class="bg-blue-600 px-4 py-2 text-white rounded-xl cursor-pointer">
                                        Scan Pengembalian
                                    </button>
                                @endif
                                @if ($detail->status_pengambilan != 'diambil' && $peminjaman->status == 'disetujui')
                                    <button
                                        onclick="openScanModal('{{ $peminjaman->id }}','{{ $detail->alat->kode_barang }}')"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">
                                        Scan QR
                                    </button>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- ================= MODAL SCAN ================= -->
    <div id="scanModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-2xl p-6 w-96 relative">

            <button onclick="closeScanModal()" class="absolute top-3 right-3 text-gray-500 hover:text-black">
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4 text-center">
                Scan QR Barang
            </h2>

            <input type="hidden" id="id_peminjaman">
            <input type="hidden" id="kode_barang">

            <!-- Switch Mode -->
            <div class="flex justify-center gap-2 mb-4">
                <button onclick="showCamera()" class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">
                    Kamera
                </button>
                <button onclick="showUpload()" class="px-3 py-1 bg-gray-200 rounded-lg text-sm">
                    Upload
                </button>
            </div>

            <!-- CAMERA SCAN -->
            <div id="cameraSection">
                <div id="reader" class="w-72 mx-auto mb-4"></div>
            </div>

            <!-- UPLOAD SCAN -->
            <div id="uploadSection" class="hidden">
                <form action="{{ route('petugas.peminjaman.scan.verify') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_peminjaman" id="upload_peminjaman_id">

                    <input type="file" name="qr_file" accept="image/*" class="w-full border rounded-lg p-2 text-sm mb-3">

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-xl hover:bg-blue-700">
                        Upload & Verifikasi
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrCode;

        function openScanModal(peminjamanId, kodeBarang) {
            document.getElementById('scanModal').classList.remove('hidden');
            document.getElementById('scanModal').classList.add('flex');

            document.getElementById('id_peminjaman').value = peminjamanId;
            document.getElementById('kode_barang').value = kodeBarang;
            document.getElementById('upload_peminjaman_id').value = peminjamanId;

            showCamera();
        }

        function closeScanModal() {
            const modal = document.getElementById("scanModal");
            modal.classList.add("hidden");

            // ✅ Stop hanya jika scanner aktif
            if (html5QrCode && scannerRunning) {
                html5QrCode.stop().then(() => {
                    scannerRunning = false;
                    html5QrCode.clear();
                }).catch(err => console.log(err));
            }
        }

        function showCamera() {
            document.getElementById('cameraSection').classList.remove('hidden');
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
            document.getElementById('cameraSection').classList.add('hidden');
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
            pid.name = 'id_peminjaman';
            pid.value = document.getElementById('id_peminjaman').value; // ✅ fix

            const kode = document.createElement('input');
            kode.type = 'hidden';
            kode.name = 'kode_barang';
            kode.value = result; // ✅ ini sudah benar, isi dari hasil scan

            form.appendChild(csrf);
            form.appendChild(pid);
            form.appendChild(kode);
            document.body.appendChild(form);
            form.submit();
        }
    </script>

@endsection
