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
    <link href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('admin-template/css/materialdesignicons.min.css') }}">
    {{-- Tambah CSS tambahan di sini jika perlu --}}

    {{-- alert  Toastr --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    

</head>

<body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

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
            &copy; {{ date('Y') }} Rancang Bangun Sistem Informasi Penjualan Kambing | Usaha Ternak Kamberu -
            Belopa, Luwu.
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
    <script src="{{ asset('js/app.js') }}"></script>

    @stack('scripts') {{-- Untuk menambahkan script dari child blade --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-right", 
            "timeOut": "5000"
        }
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.info("{{ Session::get('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.warning("{{ Session::get('warning') }}");
        @endif
    </script>

</body>

</html>
