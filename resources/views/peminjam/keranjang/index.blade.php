@extends('layouts.peminjam')

@section('title', 'Keranjang Peminjaman')

@section('content')

    <div class="pt-6 px-4 flex justify-center">
        <div class="w-full min-h-screen bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8">

            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white mb-8">
                Keranjang Peminjaman
            </h2>

            {{-- Jika Kosong --}}
            @if (count($keranjang) == 0)
                <p class="text-center text-gray-500">
                    Keranjang masih kosong
                </p>
            @else
                {{-- LIST ITEM --}}
                <div class="space-y-5">

                    @foreach ($keranjang as $id => $item)
                        <div
                            class="relative flex items-center justify-between
                        bg-white dark:bg-slate-700
                        rounded-2xl shadow-md p-5 hover:shadow-lg transition">

                            {{-- Checkbox --}}
                            <div class="absolute top-4 left-4">
                                <input type="checkbox" class="alat-checkbox w-5 h-5 rounded text-green-600"
                                    value="{{ $id }}">
                            </div>

                            {{-- Info --}}
                            <div class="flex items-center gap-4 pl-10">

                                <div
                                    class="w-14 h-14 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-slate-600">
                                    <i class="fas fa-toolbox text-2xl text-gray-500"></i>
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                                        {{ $item['nama'] }}
                                    </h3>

                                    <p class="text-sm text-gray-500 dark:text-gray-300">
                                        Jumlah dipinjam:
                                        <span class="font-semibold">{{ $item['jumlah'] }}</span>
                                    </p>
                                </div>
                            </div>

                            {{-- Action --}}
                            <div class="flex items-center gap-3">

                                {{-- Minus --}}
                                <form action="{{ route('siswa.keranjang.update', $id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="jumlah" value="{{ $item['jumlah'] - 1 }}">
                                    <button type="submit"
                                        class="w-9 h-9 rounded-full bg-gray-200 hover:bg-gray-300
                                    flex items-center justify-center text-lg font-bold"
                                        {{ $item['jumlah'] <= 1 ? 'disabled' : '' }}>
                                        −
                                    </button>
                                </form>

                                {{-- Angka --}}
                                <span class="text-lg font-bold text-gray-800 dark:text-white">
                                    {{ $item['jumlah'] }}
                                </span>

                                {{-- Plus --}}
                                <form action="{{ route('siswa.keranjang.update', $id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="jumlah" value="{{ $item['jumlah'] + 1 }}">
                                    <button type="submit"
                                        class="w-9 h-9 rounded-full bg-green-500 hover:bg-green-600
                                    flex items-center justify-center text-white text-lg font-bold">
                                        +
                                    </button>
                                </form>

                                {{-- Hapus --}}
                                <form action="{{ route('siswa.keranjang.hapus', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-10 h-10 flex items-center justify-center
                                    rounded-xl bg-red-500 hover:bg-red-600 text-white">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Tombol Checkout --}}
                <div class="mt-8 flex justify-end">
                    <button id="btnCheckout" class="px-7 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 shadow">
                        Checkout (0)
                    </button>
                </div>


                {{-- MODAL --}}
                <div id="checkoutModal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/50">

                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg w-full max-w-lg p-6">

                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-5">
                            Form Pengajuan Peminjaman
                        </h3>

                        {{-- FORM CHECKOUT --}}
                        <form action="{{ route('siswa.keranjang.checkout') }}" method="POST">
                            @csrf

                            {{-- Hidden Selected --}}
                            <div id="selectedContainer"></div>

                            {{-- Tanggal Ambil --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-white mb-1">
                                    Tanggal Pengambilan
                                </label>
                                <input type="date" name="tanggal_booking"
                                    class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:text-white" required>
                            </div>

                            {{-- Tanggal Kembali --}}
                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-white mb-1">
                                    Tanggal Pengembalian
                                </label>
                                <input type="date" name="tanggal_kembali_rencana"
                                    class="w-full rounded-lg border-gray-300 dark:bg-slate-700 dark:text-white" required>
                            </div>


                            {{-- Tombol --}}
                            <div class="flex justify-end gap-3 mt-6">

                                <button type="button" id="btnClose"
                                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                                    Batal
                                </button>

                                <button type="submit"
                                    class="px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Ajukan Peminjaman
                                </button>

                            </div>

                        </form>
                    </div>
                </div>

            @endif
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        const modal = document.getElementById("checkoutModal");
        const btnCheckout = document.getElementById("btnCheckout");
        const btnClose = document.getElementById("btnClose");

        btnCheckout.addEventListener("click", function() {

            let selectedContainer = document.getElementById("selectedContainer");
            selectedContainer.innerHTML = "";

            let checked = document.querySelectorAll(".alat-checkbox:checked");

            if (checked.length === 0) {
                alert("Pilih minimal 1 alat untuk checkout!");
                return;
            }

            checked.forEach(cb => {
                selectedContainer.innerHTML += `
                <input type="hidden" name="alat_selected[]" value="${cb.value}">
            `;
            });

            modal.classList.remove("hidden");
        });

        btnClose.addEventListener("click", function() {
            modal.classList.add("hidden");
        });
    </script>

@endsection
