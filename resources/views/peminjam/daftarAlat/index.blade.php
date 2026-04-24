@extends('layouts.peminjam')

@section('title', 'daftar buku')

@section('content')
    <div class="p-4 md:p-6 overflow-x-hidden mt-4 min-h-screen bg-gray-50 rounded-2xl">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white text-gray-900 p-6 rounded-lg shadow-md mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-center bg-primary bg-clip-text text-transparent">
                    Daftar Buku
                </h1>
                <p class="text-center text-gray-600 mt-2">Jelajahi koleksi buku yang tersedia untuk
                    dipinjam</p>
            </div>

            <!-- Search and Filter Section -->
            <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" id="searchInput" placeholder="Cari buku..."
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white  text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>
                    <div class="flex gap-2">
                        <button
                            class="filter-btn px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                            <i class="fas fa-filter mr-2"></i>Semua
                        </button>
                        <button
                            class="filter-btn px-6 py-3 bg-gray-500 hover:bg-slate-600 text-gray-100 rounded-lg font-semibold transition-all duration-300">
                            <i class="fas fa-check-circle mr-2"></i>Tersedia
                        </button>
                    </div>
                </div>
            </div>

            <!-- Equipment Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($alat as $row)
                    <div
                        class="equipment-card bg-white bg-slate-800 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                        <!-- Image Section -->
                        <div
                            class="relative h-48 bg-linear-to-br from-blue-100 to-purple-100 from-slate-700 to-slate-600 overflow-hidden">
                            @if ($row->foto_buku)
                                <img src="{{ Storage::url($row->foto_buku) }}" alt="{{ $row->nama_alat }}"
                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                            @else
                                <img src="{{ asset('assets/no-image.png') }}" alt="No Image"
                                    class="w-full h-full object-cover opacity-50">
                            @endif

                            <!-- Stock Badge -->
                            <div class="absolute top-3 right-3">
                                @if ($row->stok > 0)
                                    <span
                                        class="px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-check-circle mr-1"></i>Tersedia
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-times-circle mr-1"></i>Habis
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-4">
                            <!-- Equipment Name -->
                            <h3 class="text-lg font-bold text-gray-900  mb-2 line-clamp-2 min-h-14">
                                {{ $row->judul_buku }}
                            </h3>

                            <!-- Stock Info -->
                            <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-200 ">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-box text-blue-600 "></i>
                                    <span class="text-sm text-gray-600">Stok:</span>
                                </div>
                                <span
                                    class="text-xl font-bold {{ $row->stok > 0 ? 'text-green-600 ' : 'text-red-600 ?>' }}">
                                    {{ $row->stok }}
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('siswa.data-alat.show', $row->id) }}"
                                    class="w-full text-center px-4 py-2.5 bg-linear-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-info-circle mr-2"></i>Lihat Detail
                                </a>



                                @if ($row->stok > 0)
                                    <form action="{{ route('siswa.keranjang.tambah', $row->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full px-4 py-2.5 cursor-pointer rounded-lg bg-green-700 text-white hover:bg-green-600 font-semibold shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                            <i class="fa-solid fa-cart-shopping"></i> Tambah
                                        </button>


                                    </form>
                                @else
                                    <button disabled
                                        class="w-full text-center px-4 py-2.5 bg-gray-400 bg-gray-600 text-white rounded-lg font-semibold cursor-not-allowed opacity-60">
                                        <i class="fas fa-ban mr-2"></i>Stok Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if ($alat->isEmpty())
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="mb-4">
                        <i class="fas fa-inbox text-6xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Alat Tersedia</h3>
                    <p class="text-gray-600">Saat ini belum ada alat yang tersedia untuk dipinjam.</p>
                </div>
            @endif

            <!-- Pagination (if using pagination) -->
            @if (method_exists($alat, 'links'))
                <div class="mt-8">
                    {{ $alat->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for Search and Filter -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const equipmentCards = document.querySelectorAll('.equipment-card');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                equipmentCards.forEach(card => {
                    const equipmentName = card.querySelector('h3').textContent.toLowerCase();

                    if (equipmentName.includes(searchTerm)) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'scale(1)';
                        }, 10);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'scale(0.9)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 300);
                    }
                });
            });

            // Filter functionality
            const filterBtns = document.querySelectorAll('.filter-btn');

            filterBtns.forEach((btn, index) => {
                btn.addEventListener('click', function() {
                    // Update active button
                    filterBtns.forEach(b => {
                        b.classList.remove('bg-blue-600', 'hover:bg-blue-700',
                            'text-white');
                        b.classList.add('bg-gray-200', 'hover:bg-gray-300',
                            'bg-slate-700', 'hover:bg-slate-600',
                            'text-gray-800', 'text-gray-100');
                    });

                    this.classList.remove('bg-gray-200', 'hover:bg-gray-300', 'bg-slate-700',
                        'hover:bg-slate-600', 'text-gray-800', 'text-gray-100');
                    this.classList.add('bg-blue-600', 'hover:bg-blue-700', 'text-white');

                    // Filter cards
                    equipmentCards.forEach(card => {
                        const stockBadge = card.querySelector('.absolute span');
                        const isAvailable = stockBadge.textContent.includes('Tersedia');

                        if (index === 0) { // Show all
                            card.style.display = 'block';
                        } else if (index === 1 && isAvailable) { // Show available only
                            card.style.display = 'block';
                        } else if (index === 1 && !isAvailable) {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    <style>
        .equipment-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>



@endsection
