<header
    class="bg-white border border-gray-200
           px-6 py-4
           flex items-center justify-between
           rounded-2xl shadow-md
           ">

    {{-- LEFT : Page Title --}}
    <div class="flex items-center gap-4">

        <button class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition"
            onclick="document.getElementById('mobileSidebar').classList.remove('hidden')">
            <i class="fa-solid fa-bars text-lg"></i>
        </button>


        <div class="leading-tight">
            <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wide">
                @yield('title')
            </h3>
            <p class="text-xs text-gray-500 hidden sm:block">
                <span class="text-primary font-bold">ANTARSA</span> - <span class="text-gray-800 font-bold">Aplikasi
                    Antrian Pustaka</span>
            </p>
        </div>
    </div>

    <a href="{{ route('siswa.profile-peminjam.index') }}"
        class="flex items-center gap-3 rounded-xl
               hover:bg-primary_light/20
               px-3 py-2 transition group">

        {{-- Foto --}}
        <div class="relative">
            <div
                class="h-9 w-9 rounded-full overflow-hidden
                       border-2 border-gray-200
                       shadow-sm
                       group-hover:border-primary transition">
                <img src="{{ asset('assets/logo/logo-arsa.png') }}" alt="Profile" class="w-full h-full object-cover">
            </div>

            {{-- Status --}}
            <span
                class="absolute bottom-0 right-0
                       w-3 h-3 bg-green-500
                       rounded-full border-2 border-white">
            </span>
        </div>

        {{-- Nama & Role --}}
        <div class="hidden sm:block leading-tight">
            <p class="text-gray-800 font-semibold text-sm">
                {{ $peminjam->name ?? 'peminjam 1' }}
            </p>
            <p class="text-gray-500 text-xs">
                {{ $peminjam->role ?? 'Peminjam' }}
            </p>
        </div>

    </a>

</header>



{{-- Mobile Sidebar Overlay --}}
<div id="mobileSidebar" class="fixed inset-0 bg-black/40 hidden md:hidden z-50">

    <div class="w-64 bg-white h-full p-6 shadow-xl">

        <button class="mb-6 px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 transition"
            onclick="document.getElementById('mobileSidebar').classList.add('hidden')">
            <i class="fa-solid fa-xmark"></i> Close
        </button>

        <nav class="space-y-1">

            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded-xl hover:bg-gray-100 text-gray-700">
                Dashboard
            </a>

            <a href="#" class="block px-4 py-2 rounded-xl hover:bg-gray-100 text-gray-700">
                Data User
            </a>

            <a href="#" class="block px-4 py-2 rounded-xl hover:bg-gray-100 text-gray-700">
                Data Alat
            </a>

            <a href="#" class="block px-4 py-2 rounded-xl hover:bg-gray-100 text-gray-700">
                Kategori Alat
            </a>

            <a href="#" class="block px-4 py-2 rounded-xl hover:bg-gray-100 text-gray-700">
                Laporan
            </a>

        </nav>
    </div>
</div>
