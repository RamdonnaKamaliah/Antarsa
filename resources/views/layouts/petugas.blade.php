<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-50 bg-slate-900 overflow-x-hidden h-screen flex">

    <aside class="fixed inset-y-0 left-0 z-50 shadow-xl transition-all duration-300 xl:translate-x-0 -translate-x-full"
        id="sidebar">
        @include('components.PetugasSidebar')
    </aside>

    <div class="flex-1 flex flex-col min-w-0 xl:ml-68 transition-all duration-300">

        <div class="fixed top-0 left-0 right-0 min-h-72 bg-primary"></div>

        <div class="sticky top-0 z-40 w-full px-2 pt-4">
            @include('components.PetugasNavbar')
        </div>

        <main class="w-full px-6 py-6 relative">
            <div id="tw" class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        <footer class="p-6 text-center text-sm text-slate-400">
            © 2026 **ARSA System**
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @stack('scripts')


    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'rounded-2xl',
                }
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Waduh...',
                text: "{{ session('error') }}",
                confirmButtonColor: '#3085d6',
            });
        @endif
    </script>

    <script>
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                const form = this.closest('form');
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data kategori ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-lg',
                        cancelButton: 'rounded-lg'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>


</body>

</html>
