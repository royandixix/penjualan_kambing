<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Ternak Kamberu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (untuk icon seperti bi-cart, bi-person) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<style>
    .nav-link {
        transition: all 0.3s ease-in-out;
    }

    .nav-link:hover {
        color: #0d6efd !important;
        text-decoration: underline;
    }

    .hover-underline:hover {
        text-decoration: underline;
    }
</style>

<body>

    @include('user.layout.header') {{-- navbar --}}

    <div class="container mt-4">
        @yield('content') {{-- isi halaman --}}
    </div>

    @include('user.layout.footer') {{-- footer --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
