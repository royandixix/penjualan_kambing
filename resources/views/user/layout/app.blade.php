<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title') | Ternak Kamberu</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
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

        #toast-container {
            bottom: 20px !important;
            right: 20px !important;
            top: auto !important;
            left: auto !important;
        }
    </style>
</head>

<body>

    @include('user.layout.header') {{-- navbar --}}

    <div class="container mt-4">
        @yield('content') {{-- isi halaman --}}
    </div>

    @include('user.layout.footer') {{-- footer --}}

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JQuery & Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Toastr Configuration -->
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            timeOut: 5000,
            showMethod: "fadeIn",
            hideMethod: "fadeOut", 
            showEasing: "swing",
            hideEasing: "linear",
            showDuration: 300,
            hideDuration: 300
        };

        // Flash message dari Laravel session
        @if(Session::has('success'))
            toastr.success("🎉 {{ Session::get('success') }}", "Berhasil");
        @endif

        @if(Session::has('error'))
            toastr.error("😢 {{ Session::get('error') }}", "Gagal");
        @endif

        @if(Session::has('warning'))
            toastr.warning("⚠️ {{ Session::get('warning') }}", "Peringatan");
        @endif

        @if(Session::has('info'))
            toastr.info("ℹ️ {{ Session::get('info') }}", "Informasi");
        @endif
    </script>

    @stack('scripts')

</body>

</html>
