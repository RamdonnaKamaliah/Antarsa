@extends('layouts.peminjam')

@section('title', 'Keranjang ANTARSA')

@section('content')
    <div class="max-w-6xl mx-auto py-10 px-4 min-h-screen">
        {{-- Header --}}
        <div class="relative overflow-hidden bg-white border border-slate-100 p-8 rounded-3xl shadow-sm mb-10">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-green-50 rounded-full blur-3xl opacity-60"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-blue-50 rounded-full blur-2xl opacity-50"></div>

            <div class="relative flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-2 h-10 bg-green-500 rounded-full shadow-[0_0_15px_rgba(34,197,94,0.4)]"></div>
                        <div>
                            <h1 class="text-3xl font-black text-slate-800 uppercase tracking-tighter leading-none">
                                Keranjang Pinjam
                            </h1>
                        </div>
                    </div>
                    <p class="text-slate-500 text-sm ml-5">
                        Kelola koleksi buku yang ingin kamu pelajari di
                        <span class="font-bold text-green-600">ANTARSA</span>.
                    </p>
                </div>

                <a href="{{ route('siswa.data-alat.index') }}"
                    class="group bg-green-50 text-green-700 px-6 py-3 rounded-2xl text-sm font-bold hover:bg-green-600 hover:text-white transition-all duration-300 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-plus-circle group-hover:rotate-90 transition-transform duration-300"></i>
                    Tambah Buku Lagi
                </a>
            </div>
        </div>

        @if (count($keranjang) == 0)
            {{-- State Kosong --}}
            <div class="bg-white rounded-3xl p-20 text-center border-2 border-dashed border-slate-200 border-slate-700">
                <div class="w-24 h-24 bg-slate-50 mx-auto rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-shopping-basket text-slate-300 text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white">Wah, Keranjangmu Sepi...</h3>
                <p class="text-slate-500  mb-8 max-w-xs mx-auto">Sepertinya belum ada buku yang kamu
                    pilih. Yuk, mulai petualangan literasimu!</p>
                <a href="{{ route('siswa.data-alat.index') }}"
                    class="px-8 py-3 bg-green-600 text-white rounded-2xl font-black shadow-xl shadow-green-200 transition-all hover:-translate-y-1 hover:bg-green-700">CARI
                    BUKU</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- LIST BUKU (KIRI) --}}
                <div class="lg:col-span-2 space-y-5">
                    @foreach ($keranjang as $id => $item)
                        <div
                            class="bg-white  rounded-2xl border border-slate-100 p-5 flex flex-col sm:flex-row items-center gap-6 group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300">

                            {{-- Checkbox --}}
                            <div class="flex items-center">
                                <input type="checkbox"
                                    class="alat-checkbox w-7 h-7 rounded-xl border-slate-300 text-green-600 focus:ring-green-500 cursor-pointer transition-all"
                                    value="{{ $id }}">
                            </div>

                            {{-- Foto Buku --}}
                            <div
                                class="w-28 h-36 flex-shrink-0 bg-slate-100 rounded-2xl overflow-hidden shadow-inner group-hover:rotate-2 transition-transform">
                                @if ($item['foto'])
                                    <img src="{{ asset('storage/' . $item['foto']) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <i class="fas fa-book text-3xl"></i>
                                    </div>
                                @endif
                            </div>

                            {{-- Detail Informasi --}}
                            <div class="flex-1 text-center sm:text-left">
                                <div
                                    class="inline-block px-3 py-1 bg-green-50  text-green-600  text-[10px] font-black uppercase tracking-widest rounded-lg mb-2">
                                    {{ $item['kategori'] }}
                                </div>
                                <h3
                                    class="text-xl font-black text-slate-800  line-clamp-1 group-hover:text-green-600 transition-colors">
                                    {{ $item['judul'] }}
                                </h3>
                                <p class="text-sm text-slate-400 font-medium mt-1 italic">Karya:
                                    {{ $item['penulis'] }}</p>

                                <div class="mt-4 flex items-center justify-center sm:justify-start gap-4">
                                    <span
                                        class="text-xs font-bold px-3 py-1 rounded-full {{ $item['stok'] > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                        Stok: {{ $item['stok'] }}
                                    </span>
                                </div>
                            </div>

                            {{-- Kontrol & Hapus --}}
                            <div
                                class="flex flex-col items-center sm:items-end gap-5 border-t sm:border-t-0 sm:border-l border-slate-50  pt-5 sm:pt-0 sm:pl-8">
                                <div class="flex items-center bg-slate-100 rounded-2xl p-1.5 border border-slate-200 ">
                                    <form action="{{ route('siswa.keranjang.update', $id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="jumlah" value="{{ $item['jumlah'] - 1 }}">
                                        <button
                                            class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-white  text-slate-500 shadow-sm transition-all"
                                            {{ $item['jumlah'] <= 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-minus text-xs"></i>
                                        </button>
                                    </form>
                                    <span
                                        class="w-12 text-center font-black text-slate-700 text-lg">{{ $item['jumlah'] }}</span>
                                    <form action="{{ route('siswa.keranjang.update', $id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="jumlah" value="{{ $item['jumlah'] + 1 }}">
                                        <button
                                            class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-white  text-green-600 shadow-sm transition-all">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                                <form action="{{ route('siswa.keranjang.hapus', $id) }}" method="POST" class="btn-delete">
                                    @csrf
                                    <button type="button"
                                        class="btn-hapus text-slate-400 hover:text-red-500 transition-colors text-xs font-bold flex items-center gap-1 uppercase tracking-tighter">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- RINGKASAN (KANAN) --}}
                <div class="lg:col-span-1">
                    <div
                        class="bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-2xl shadow-slate-200/50 shadow-none sticky top-10">
                        <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Summary Peminjaman
                        </h2>

                        <div class="space-y-6 mb-10">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 font-medium">Buku Terpilih</span>
                                <span id="selectedCount"
                                    class="w-8 h-8 flex items-center justify-center bg-green-600 text-white rounded-full font-black text-sm">0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 font-medium">Durasi Pinjam</span>
                                <span class="font-black text-slate-800">Max. 7 Hari</span>
                            </div>
                            <div class="pt-6 border-t border-slate-50 ">
                                <p class="text-[10px] text-slate-400 leading-relaxed italic">*Pastikan mengembalikan tepat
                                    waktu untuk menghindari denda/blokir akun.</p>
                            </div>
                        </div>

                        @if ($adaTunggakan)
                            <div class="p-5 bg-red-50 rounded-3xl mb-8 border border-red-100 ">
                                <div class="flex items-center gap-2 text-red-600 font-black text-xs uppercase mb-2">
                                    <i class="fas fa-shield-alt"></i> Akses Terkunci
                                </div>
                                <p class="text-[11px] text-red-500 leading-relaxed font-medium">Kamu memiliki tanggungan
                                    buku yang belum dikembalikan. Yuk, selesaikan dulu!</p>
                            </div>
                        @endif

                        <button id="btnCheckout"
                            class="w-full py-5 rounded-[1.5rem] font-black tracking-tighter transition-all flex items-center justify-center gap-3 {{ $adaTunggakan ? 'bg-slate-100 text-slate-400 cursor-not-allowed' : 'bg-green-600 text-white shadow-xl shadow-green-200 hover:scale-[1.03] active:scale-95' }}"
                            {{ $adaTunggakan ? 'disabled' : '' }}>
                            PINJAM SEKARANG <i class="fas fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- MODAL CHECKOUT --}}
    <div id="checkoutModal" class="hidden fixed inset-0 z-[999] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-md"></div>
        <div class="relative bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="bg-green-600 p-8 text-white">
                <h3 class="text-2xl font-black uppercase tracking-tight">Atur Jadwal</h3>
                <p class="text-green-100 text-sm mt-1">Kapan kamu akan mengambil buku ini?</p>
            </div>

            <form action="{{ route('siswa.keranjang.checkout') }}" method="POST" class="p-8">
                @csrf
                <div id="selectedContainer"></div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Rencana
                            Pengambilan</label>
                        <input type="date" name="tanggal_booking" id="inputTglBooking"
                            class="w-full h-14 px-4 rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all font-bold"
                            required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Tenggat
                            Pengembalian</label>
                        <input type="date" name="tanggal_kembali_rencana" id="inputTglKembali"
                            class="w-full h-14 px-4 rounded-2xl border-slate-200 bg-slate-50 focus:ring-4 focus:ring-green-500/20 focus:border-green-500 transition-all font-bold"
                            required>
                        <p id="errorMsg"
                            class="text-red-500 text-[10px] mt-3 hidden font-black bg-red-50 p-3 rounded-xl">
                            <i class="fas fa-exclamation-triangle mr-1 text-xs"></i> DURASI PINJAM MAKSIMAL 7 HARI!
                        </p>
                    </div>
                </div>

                <div class="flex gap-4 mt-10">
                    <button type="button" id="btnClose"
                        class="flex-1 py-4 text-slate-400 font-black hover:text-slate-600 transition-colors uppercase text-xs tracking-widest">Batal</button>
                    <button type="submit" id="btnSubmitModal"
                        class="flex-2 px-10 py-4 bg-green-600 text-white font-black rounded-2xl shadow-lg shadow-green-100 uppercase text-xs tracking-widest hover:bg-green-700 transition-all">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Logic Checkbox & Count
        const checkboxes = document.querySelectorAll('.alat-checkbox');
        const selectedCountLabel = document.getElementById('selectedCount');

        checkboxes.forEach(cb => {
            cb.addEventListener('change', () => {
                const count = document.querySelectorAll('.alat-checkbox:checked').length;
                selectedCountLabel.innerText = count;
                selectedCountLabel.classList.add('scale-125');
                setTimeout(() => selectedCountLabel.classList.remove('scale-125'), 200);
            });
        });

        // Validasi Tanggal
        const inputTglBooking = document.getElementById('inputTglBooking');
        const inputTglKembali = document.getElementById('inputTglKembali');
        const errorMsg = document.getElementById('errorMsg');
        const btnSubmitModal = document.getElementById('btnSubmitModal');

        function validasiTanggal() {
            if (inputTglBooking.value && inputTglKembali.value) {
                const ambil = new Date(inputTglBooking.value);
                const kembali = new Date(inputTglKembali.value);
                const selisihHari = (kembali - ambil) / (1000 * 60 * 60 * 24);

                if (selisihHari > 7 || selisihHari < 0) {
                    errorMsg.classList.remove('hidden');
                    btnSubmitModal.disabled = true;
                    btnSubmitModal.classList.add('opacity-30', 'cursor-not-allowed');
                } else {
                    errorMsg.classList.add('hidden');
                    btnSubmitModal.disabled = false;
                    btnSubmitModal.classList.remove('opacity-30', 'cursor-not-allowed');
                }
            }
        }

        inputTglBooking.addEventListener('change', validasiTanggal);
        inputTglKembali.addEventListener('change', validasiTanggal);

        // Modal Handle
        const modal = document.getElementById("checkoutModal");
        const btnCheckout = document.getElementById("btnCheckout");
        const btnClose = document.getElementById("btnClose");

        if (btnCheckout) {
            btnCheckout.addEventListener("click", function() {
                let selectedContainer = document.getElementById("selectedContainer");
                selectedContainer.innerHTML = "";
                let checked = document.querySelectorAll(".alat-checkbox:checked");

                if (checked.length === 0) {
                    alert("Pilih minimal 1 buku dulu ya, Donna! 😊");
                    return;
                }

                checked.forEach(cb => {
                    selectedContainer.innerHTML +=
                        `<input type="hidden" name="alat_selected[]" value="${cb.value}">`;
                });
                modal.classList.remove("hidden");
            });
        }

        btnClose.addEventListener("click", () => modal.classList.add("hidden"));
    </script>
@endsection
