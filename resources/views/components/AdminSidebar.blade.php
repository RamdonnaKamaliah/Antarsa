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
            ANTARSA
        </span>
    </div>

    <hr class="border-slate-200 mx-4 mb-3">

    {{-- Menu --}}
    <nav class="flex-1 px-3 space-y-4">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl font-sans
            {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-gauge-high w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        {{-- Akun Pengguna --}}
        <a href="{{ route('admin.akun-pengguna.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('admin.akun-pengguna*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-users w-5 text-center"></i>
            <span>Akun Pengguna</span>
        </a>

        {{-- Daftar Alat --}}
        <a href="{{ route('admin.data-buku.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('admin.data-buku*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-toolbox w-5 text-center"></i>
            <span>Daftar Buku</span>
        </a>

        {{-- Kategori Alat --}}
        <a href="{{ route('admin.kategori-alat.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('admin.kategori-alat*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-tags w-5 text-center"></i>
            <span>Kategori Buku</span>
        </a>

        {{-- peminjaman --}}
        <a href="{{ route('admin.peminjaman.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('admin.peminjaman*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-box-open w-5 text-center"></i>
            <span>Transaksi</span>
        </a>

        {{-- pengembalian --}}
        {{-- <a href="{{ route('admin.pengembalian.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('admin.pengembalian*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-undo w-5 text-center"></i>
            <span>Pengembalian</span>
        </a> --}}

        {{-- Aktivitas --}}
        <a href="{{ route('admin.aktivitas.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->routeIs('admin.aktivitas*') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fa-solid fa-clock w-5 text-center"></i>
            <span>Aktivitas</span>
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
