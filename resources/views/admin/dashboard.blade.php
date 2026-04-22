@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition duration-300">
            <h2 class="text-gray-600 text-sm">Total User</h2>
            <p class="text-3xl font-bold text-gray-800 mt-2">123</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition duration-300">
            <h2 class="text-gray-600 text-sm">Total Alat</h2>
            <p class="text-3xl font-bold text-gray-800 mt-2">35</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition duration-300">
            <h2 class="text-gray-600 text-sm">Total Peminjaman</h2>
            <p class="text-3xl font-bold text-gray-800 mt-2">35</p>
        </div>

    </div>

    {{-- Row kedua --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">

        <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition duration-300 flex flex-col items-start">
            <h2 class="text-gray-600 text-sm">Total Kembali</h2>
            <p class="text-3xl font-bold text-green-500 mt-2">112</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition duration-300 flex flex-col items-start">
            <h2 class="text-gray-600 text-sm">Barang Rusak</h2>
            <p class="text-3xl font-bold text-red-500 mt-2">3</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition duration-300 flex flex-col items-start">
            <h2 class="text-gray-600 text-sm">Peminjaman Hari Ini</h2>
            <p class="text-3xl font-bold text-blue-500 mt-2">5</p>
        </div>

        <div class="bg-white rounded-2xl shadow p-6 hover:shadow-xl transition duration-300 flex flex-col items-start">
            <h2 class="text-gray-600 text-sm">Persentase Peminjaman</h2>
            <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                <div class="bg-purple-500 h-4 rounded-full" style="width: 65%"></div>
            </div>
            <p class="text-sm text-gray-500 mt-1">65% dari total alat dipinjam</p>
        </div>

    </div>

    {{-- Optional: Grafik --}}
    <div class="bg-white rounded-2xl shadow p-6 mt-6">
        <h2 class="text-gray-600 text-sm mb-4">Peminjaman Mingguan</h2>
        <canvas id="weeklyChart" class="w-full h-64"></canvas>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('weeklyChart').getContext('2d');
            const weeklyChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        label: 'Peminjaman',
                        data: [2, 4, 5, 3, 6, 4, 8], // data statis dulu
                        backgroundColor: 'rgba(128, 90, 213, 0.2)',
                        borderColor: 'rgba(128, 90, 213, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'white',
                        pointBorderColor: 'rgba(128, 90, 213,1)',
                        pointRadius: 5,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
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
        });
    </script>
