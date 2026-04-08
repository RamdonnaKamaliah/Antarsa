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
                                    <button
                                        onclick="openReturnModal('{{ $peminjaman->id }}','{{ $detail->alat->kode_barang }}', '{{ $detail->alat->nama_alat }}')"
                                        class="bg-blue-600 px-4 py-2 cursor-pointer text-white rounded-xl hover:bg-blue-700 transition">
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
            <button onclick="closeScanModal()" class="absolute top-3 right-3 text-gray-500">✕</button>
            <h2 id="modalTitle" class="text-lg font-bold mb-4 text-center">Scan QR Barang</h2>

            <input type="hidden" id="id_peminjaman_val">
            <input type="hidden" id="kode_barang_target">
            <input type="hidden" id="scan_mode" value="ambil">

            <div class="flex justify-center gap-2 mb-4">
                <button onclick="showCamera()" class="px-3 py-1 bg-blue-600 text-white rounded-lg text-sm">Kamera</button>
                <button onclick="showUpload()" class="px-3 py-1 bg-gray-200 rounded-lg text-sm">Upload</button>
            </div>

            <div id="cameraSection">
                <div id="reader" class="w-72 mx-auto mb-4"></div>
            </div>

            <div id="uploadSection" class="hidden">
                <form id="uploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_peminjaman" id="upload_peminjaman_id">

                    <div id="kondisiUploadWrapper" class="hidden mb-3 border p-3 rounded-xl bg-gray-50">
                        <label class="block text-sm font-bold mb-2">Kondisi Barang Saat Kembali:</label>
                        <div class="flex gap-2">
                            <label class="flex-1"><input type="radio" name="kondisi" value="baik" checked> 😊
                                Baik</label>
                            <label class="flex-1"><input type="radio" name="kondisi" value="rusak"> 😟 Rusak</label>
                        </div>
                    </div>

                    <input type="file" name="qr_file" accept="image/*" class="w-full border rounded-lg p-2 text-sm mb-3">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-xl">Upload &
                        Verifikasi</button>
                </form>
            </div>
        </div>
    </div>

    <div id="returnConditionModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[60]">
        <div class="bg-white rounded-2xl p-6 w-80 text-center">
            <h2 class="font-bold mb-4">Pilih Kondisi Barang</h2>
            <form action="{{ route('petugas.pengembalian.verifyPengembalian', $peminjaman->id) }}" method="POST">
                @csrf
                <input type="hidden" name="id_peminjaman" id="ret_id_peminjaman">
                <input type="hidden" name="kode_barang" id="ret_kode_barang">
                <div class="flex gap-2 mb-4">
                    <button type="submit" name="kondisi" value="baik"
                        class="flex-1 bg-green-500 text-white py-2 rounded-lg">Baik</button>
                    <button type="submit" name="kondisi" value="rusak"
                        class="flex-1 bg-red-500 text-white py-2 rounded-lg">Rusak</button>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.parentElement.classList.add('hidden')"
                    class="text-gray-400 text-sm">Batal</button>
            </form>
        </div>
    </div>

    <div id="returnConditionModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-[60]">
        <div class="bg-white rounded-2xl p-6 w-80 text-center">
            <h2 class="font-bold mb-4">Pilih Kondisi Barang</h2>
            <form action="{{ route('petugas.pengembalian.verifyPengembalian', $peminjaman->id) }}" method="POST">
                @csrf
                <input type="hidden" name="id_peminjaman" id="ret_id_peminjaman">
                <input type="hidden" name="kode_barang" id="ret_kode_barang">
                <div class="flex gap-2 mb-4">
                    <button type="submit" name="kondisi" value="baik"
                        class="flex-1 bg-green-500 text-white py-2 rounded-lg">Baik</button>
                    <button type="submit" name="kondisi" value="rusak"
                        class="flex-1 bg-red-500 text-white py-2 rounded-lg">Rusak</button>
                </div>
                <button type="button" onclick="this.parentElement.parentElement.parentElement.classList.add('hidden')"
                    class="text-gray-400 text-sm">Batal</button>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
            let html5QrCode;

        // 1. Fungsi Pembuka Modal (Dipanggil dari tombol di tabel)
        function openScanModal(peminjamanId, kodeBarang) {
            setupModal(peminjamanId, kodeBarang, 'ambil', 'Scan QR Pengambilan');
        }

        function openReturnModal(peminjamanId, kodeBarang) {
            setupModal(peminjamanId, kodeBarang, 'kembali', 'Scan QR Pengembalian');
        }

        // 2. Setup Modal secara Dinamis
        function setupModal(peminjamanId, kodeBarang, mode, title) {
            const modal = document.getElementById('scanModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            document.getElementById('modalTitle').innerText = title;
            document.getElementById('id_peminjaman_val').value = peminjamanId;
            document.getElementById('kode_barang_target').value = kodeBarang;
            document.getElementById('scan_mode').value = mode;

            // Setup Form Upload
            document.getElementById('upload_peminjaman_id').value = peminjamanId;
            const uploadForm = document.getElementById('uploadForm');
            const kondisiWrapper = document.getElementById('kondisiUploadWrapper');

            if (mode === 'kembali') {
                uploadForm.action = "{{ route('petugas.pengembalian.verifyPengembalian', $peminjaman->id) }}"; // Route Pengembalian
                kondisiWrapper.classList.remove('hidden');
            } else {
                uploadForm.action = "{{ route('petugas.peminjaman.scan.verify') }}"; // Route Pengambilan
                kondisiWrapper.classList.add('hidden');
            }
            showCamera();
        }

        // 3. Logika Setelah Berhasil Scan (Kamera)
        function submitScan(result) {
            const mode = document.getElementById('scan_mode').value;
            const targetKode = document.getElementById('kode_barang_target').value;
            const peminjamanId = document.getElementById('id_peminjaman_val').value;

            if (result !== targetKode) {
                alert("QR Code Salah! Anda men-scan barang yang berbeda.");
                location.reload();
                return;
            }

            if (mode === 'ambil') {
                // Submit otomatis untuk pengambilan
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('petugas.peminjaman.scan.verify') }}";

                const data = {
                    _token: "{{ csrf_token() }}",
                    id_peminjaman: peminjamanId,
                    kode_barang: result
                };

                for (let key in data) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = data[key];
                    form.appendChild(input);
                }
                document.body.appendChild(form);
                form.submit();
            } else {
                // Buka modal kondisi untuk pengembalian
                closeScanModal();
                document.getElementById('returnConditionModal').classList.remove('hidden');
                document.getElementById('returnConditionModal').classList.add('flex');
                document.getElementById('ret_id_peminjaman').value = peminjamanId;
                document.getElementById('ret_kode_barang').value = result;
            }
        }

        // 4. Fungsi Helper Kamera
        function showCamera() {
            document.getElementById('cameraSection').classList.remove('hidden');
            document.getElementById('uploadSection').classList.add('hidden');

            if (html5QrCode) html5QrCode.stop();

            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 220
                },
                qrCodeMessage => {
                    html5QrCode.stop().then(() => {
                        submitScan(qrCodeMessage);
                    });
                }
            ).catch(err => console.error(err));
        }

        function showUpload() {
            if (html5QrCode) html5QrCode.stop();
            document.getElementById('cameraSection').classList.add('hidden');
            document.getElementById('uploadSection').classList.remove('hidden');
        }

        function closeScanModal() {
            document.getElementById('scanModal').classList.add('hidden');
            if (html5QrCode) html5QrCode.stop();
        } 
    </script>

@endsection

