<!-- resources/views/admin/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    <!-- CSS Template -->
    <link rel="stylesheet" href="{{ asset('admin-template/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-template/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-template/css/chartist-plugin-tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-template/css/materialdesignicons.min.css') }}">
    {{-- Tambah CSS tambahan di sini jika perlu --}}
</head>

<body>
    <div id="main-wrapper"
         data-layout="vertical"
         data-navbarbg="skin5"
         data-sidebartype="full"
         data-sidebar-position="absolute"
         data-header-position="absolute"
         data-boxed-layout="full">

        {{-- Header --}}
        @include('admin.layouts.header')

        {{-- Sidebar --}}
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar">
                @include('admin.layouts.sidebar')
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="page-wrapper">
            <div class="container-fluid py-4">
                @yield('content')
            </div>
        </div>

        {{-- Footer --}}
        <footer class="footer text-center">
            &copy; {{ date('Y') }} Rancang Bangun Sistem Informasi Penjualan Kambing | Usaha Ternak Kamberu - Belopa, Luwu. 
        </footer>
        
        
    </div>

    <!-- JS Template -->
    <script src="{{ asset('admin-template/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-template/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin-template/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('admin-template/js/waves.js') }}"></script>
    <script src="{{ asset('admin-template/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('admin-template/js/custom.js') }}"></script>
    <script src="{{ asset('admin-template/js/chartist.min.js') }}"></script>
    <script src="{{ asset('admin-template/js/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('admin-template/js/dashboard1.js') }}"></script>
    <script src="{{ asset('js/app.jss') }}"></script>

    @stack('scripts') {{-- Untuk menambahkan script dari child blade --}}
</body>

</html>
