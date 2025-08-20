<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    {{-- Template CSS --}}
    <link rel="stylesheet" href="{{ asset('admin-template/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-template/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-template/css/chartist-plugin-tooltip.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-template/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.5.95/css/materialdesignicons.min.css">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- CSS tambahan --}}
    @stack('styles')

    <style>
        /* Sidebar & Layout Styling */
        .left-sidebar {
            background-color: #ffffff !important;
        }

        .scroll-sidebar .sidebar-nav .sidebar-link {
            color: #1e1e1e !important;
            font-weight: 500;
        }

        .scroll-sidebar .sidebar-nav .sidebar-link:hover {
            background-color: #f0f0f0 !important;
            color: #000 !important;
        }

        .scroll-sidebar .sidebar-nav .sidebar-item.active>.sidebar-link {
            color: #000 !important;
            background-color: #e8e8e8 !important;
            font-weight: bold;
        }

        .page-wrapper {
            margin-left: 240px;
            padding: 20px;
            background-color: #f9f9f9;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* Responsive Sidebar */
        @media (max-width: 768px) {
            .left-sidebar {
                position: fixed;
                left: -240px;
                top: 0;
                width: 240px;
                height: 100%;
                background-color: #ffffff;
                z-index: 1050;
                transition: left 0.3s ease;
            }

            .left-sidebar.open {
                left: 0;
            }

            .page-wrapper {
                margin-left: 0 !important;
            }

            #sidebarOverlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.4);
                z-index: 1040;
            }

            #sidebarOverlay.show {
                display: block;
            }
        }

        /* Sidebar toggle button */
        #sidebarToggle {
            position: absolute;
            left: 10px;
            top: 10px;
            z-index: 1100;
            background: transparent;
            border: none;
            font-size: 24px;
            display: none;
        }

        @media (max-width: 768px) {
            #sidebarToggle {
                display: block;
            }
        }

        .sticky-sidebar {
    position: sticky;
    top: 70px; /* Sesuaikan dengan tinggi header */
    z-index: 999;
    background-color: #ffffff;
}

    </style>
</head>

<body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">

        {{-- Sidebar Toggle Button --}}
       

        {{-- Overlay untuk mobile --}}
        <div id="sidebarOverlay" onclick="toggleSidebar()"></div>

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

    {{-- Template JS --}}
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

    {{-- Toastr & jQuery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- Script tambahan --}}
    @stack('scripts')

    {{-- Sidebar Toggle Script --}}
    <script>
        const sidebar = document.querySelector('.left-sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');

        function toggleSidebar() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        toggleBtn.addEventListener('click', toggleSidebar);
    </script>

    {{-- Toastr Alerts --}}
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            timeOut: "5000"
        };

        @if(Session::has('success')) toastr.success("{{ Session::get('success') }}"); @endif
        @if(Session::has('error')) toastr.error("{{ Session::get('error') }}"); @endif
        @if(Session::has('info')) toastr.info("{{ Session::get('info') }}"); @endif
        @if(Session::has('warning')) toastr.warning("{{ Session::get('warning') }}"); @endif
    </script>
</body>

</html>