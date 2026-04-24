@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
    {{-- SECTION: STAT CARDS --}}
    <div class="space-y-4">

        {{-- Row 1: 3 Kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Card: Total User --}}
            <div
                class="group relative bg-white rounded-2xl border border-slate-100  p-6 overflow-hidden hover:shadow-lg hover:shadow-violet-100 hover:shadow-none hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-violet-500 rounded-b-2xl"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-violet-600 " fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </div>
                    <span
                        class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full bg-violet-50 text-violet-600 text-violet-400">
                        Terdaftar
                    </span>
                </div>
                <p class="text-sm text-slate-500  font-medium mb-1">Total user</p>
                <p class="text-3xl font-black text-slate-800 tracking-tight">{{ $totalUser }}</p>
            </div>

            {{-- Card: Total Buku --}}
            <div
                class="group relative bg-white rounded-2xl border border-slate-100 p-6 overflow-hidden hover:shadow-lg hover:shadow-teal-100  hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-teal-500 rounded-b-2xl"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-teal-600 " fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                        </svg>
                    </div>
                    <span
                        class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full bg-teal-50 bg-teal-900/30 text-teal-600 text-teal-400">
                        Koleksi
                    </span>
                </div>
                <p class="text-sm text-slate-500 font-medium mb-1">Total buku</p>
                <p class="text-3xl font-black text-slate-800  tracking-tight">{{ $totalAlat }}</p>
            </div>

            {{-- Card: Total Peminjaman --}}
            <div
                class="group relative bg-white rounded-2xl border border-slate-100 border-slate-700 p-6 overflow-hidden hover:shadow-lg hover:shadow-blue-100 hover:shadow-none hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-blue-500 rounded-b-2xl"></div>
                <div class="flex items-start justify-between mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50  flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 " fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" y1="13" x2="8" y2="13" />
                            <line x1="16" y1="17" x2="8" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                    </div>
                    <span
                        class="text-[10px] font-bold uppercase tracking-widest px-2.5 py-1 rounded-full bg-blue-50 bg-blue-900/30 text-blue-600 text-blue-400">
                        Semua waktu
                    </span>
                </div>
                <p class="text-sm text-slate-500  font-medium mb-1">Total peminjaman</p>
                <p class="text-3xl font-black text-slate-800  tracking-tight">{{ $totalPeminjaman }}</p>
            </div>

        </div>

        {{-- Row 2: 4 Kolom --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Card: Total Kembali --}}
            <div
                class="relative bg-white rounded-2xl border border-slate-100  p-5 overflow-hidden hover:shadow-lg hover:shadow-green-100  hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-green-500 rounded-b-2xl"></div>
                <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center mb-4">
                    <svg class="w-4 h-4 text-green-600 " fill="none" stroke="currentColor"
                        stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <p class="text-xs text-slate-500  font-medium mb-1">Total kembali</p>
                <p class="text-2xl font-black text-green-600  tracking-tight">{{ $totalKembali }}</p>
            </div>

            {{-- Card: Buku Rusak --}}
            <div
                class="relative bg-white  rounded-2xl border border-slate-100  p-5 overflow-hidden hover:shadow-lg hover:shadow-red-100 hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-red-500 rounded-b-2xl"></div>
                <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center mb-4">
                    <svg class="w-4 h-4 text-red-600 " fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                </div>
                <p class="text-xs text-slate-500 font-medium mb-1">Buku rusak</p>
                <p class="text-2xl font-black text-red-600 tracking-tight">3</p>
            </div>

            {{-- Card: Peminjaman Hari Ini --}}
            <div
                class="relative bg-white rounded-2xl border border-slate-100 p-5 overflow-hidden hover:shadow-lg hover:shadow-amber-100  hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500 rounded-b-2xl"></div>
                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center mb-4">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <line x1="16" y1="2" x2="16" y2="6" />
                        <line x1="8" y1="2" x2="8" y2="6" />
                        <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                </div>
                <p class="text-xs text-slate-500  font-medium mb-1">Peminjaman hari ini</p>
                <p class="text-2xl font-black text-amber-600 tracking-tight">{{ $pinjamHariIni }}</p>
            </div>

            {{-- Card: Persentase Peminjaman --}}
            <div
                class="relative bg-white rounded-2xl border border-slate-100  p-5 overflow-hidden hover:shadow-lg hover:shadow-violet-100 hover:shadow-none hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-violet-500 rounded-b-2xl"></div>
                <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center mb-4">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <line x1="18" y1="20" x2="18" y2="10" />
                        <line x1="12" y1="20" x2="12" y2="4" />
                        <line x1="6" y1="20" x2="6" y2="14" />
                    </svg>
                </div>
                <p class="text-xs text-slate-500 font-medium mb-1">Stok dipinjam</p>
                <p class="text-2xl font-black text-violet-600 tracking-tight mb-3">
                    {{ $persentase }}%</p>
                <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                    <div class="h-1.5 rounded-full bg-violet-500 transition-all duration-500"
                        style="width: {{ $persentase }}%"></div>
                </div>
                <p class="text-[10px] text-slate-400 mt-2">dari total stok tersedia</p>
            </div>

        </div>

    </div>

    {{-- Grafik --}}
    <div class="bg-white rounded-2xl shadow p-6 mt-6">
        <h2 class="text-gray-600 text-sm mb-4">Peminjaman Mingguan</h2>
        <div class="relative h-[300px] w-full">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklyChart');

            // Cek di console log (F12) apakah data masuk atau tidak
            const dataLaravel = @json($grafikPeminjaman);
            const labelsLaravel = @json($labels);
            console.log("Data Grafik:", dataLaravel);

            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labelsLaravel,
                        datasets: [{
                            label: 'Total Peminjaman',
                            data: dataLaravel,
                            borderColor: 'rgba(128, 90, 213, 1)',
                            backgroundColor: 'rgba(128, 90, 213, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
