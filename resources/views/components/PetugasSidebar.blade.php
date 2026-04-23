<aside id="sidebar"
    class="hidden md:flex w-64 flex-col
           bg-white rounded-2xl shadow-lg
           border border-gray-200
           ml-3 my-4 h-[calc(100vh-2rem)]">

    {{-- Logo --}}
    <div class="py-6 flex items-center justify-center gap-2">
        <img src="{{ asset('assets/logo/logo-arsa.png') }}"
            class="w-10 h-10 rounded-xl border border-gray-200 bg-white shadow-sm">
        <span class="text-xl font-bold text-slate-800">
            ARSA
        </span>
    </div>

    <hr class="border-slate-200 mx-4 mb-3">

    {{-- Menu --}}
    <nav class="flex-1 px-3 space-y-4">

        {{-- Dashboard --}}
        <a href="{{ route('petugas.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl font-sans
            {{ request()->routeIs('petugas.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-gauge-high w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        {{-- Peminjaman --}}
        <a href="{{ route('petugas.peminjaman.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('petugas.peminjaman*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-users w-5 text-center"></i>
            <span>Peminjaman</span>
        </a>

        {{-- pengembalian --}}
        <a href="{{ route('petugas.pengembalian.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('petugas.pengembalian*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-toolbox w-5 text-center"></i>
            <span>Pengembalian</span>
        </a>


        {{-- Laporan --}}
        <a href="{{ route('petugas.laporan') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('petugas.laporan*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-file-lines w-5 text-center"></i>
            <span>Laporan</span>
        </a>

        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium cursor-pointer
                           text-red-500 hover:bg-red-50 hover:bg-red-500/10 transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </li>
    </nav>

    {{-- Footer --}}
    <div class="px-4 py-3 text-xs text-gray-500 border-t">
        © {{ date('Y') }} <span class="font-semibold">ARSA System</span>
    </div>
</aside>
