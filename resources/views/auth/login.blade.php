<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Kamberu</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        html, body {
            height: 100%;
            background-image: url('{{ asset('img/kambing.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .form-signin {
            max-width: 360px;
            padding: 2rem;
            margin: 200px auto 0;
            border-radius: 12px;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        #toast-container {
            bottom: 50px !important;
            top: auto !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
        }
    </style>
</head>

<body class="d-flex align-items-center py-4">

    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <h1 class="h3 mb-4 fw-bold text-center">Silakan Login</h1>

            {{-- Nama Pengguna --}}
            <div class="form-floating mb-2">
                <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nama Pengguna" required autofocus>
                <label for="floatingName">Nama Pengguna</label>
            </div>

            {{-- Password --}}
            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>

            {{-- Tombol Login --}}
            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Login</button>

            {{-- Link ke Register --}}
            <p class="text-center text-white">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>

            <p class="mt-5 mb-3 text-center text-white">&copy; Kamberu 2025</p>
        </form>
    </main>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Konfigurasi Toastr
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-right",
            timeOut: 5000,
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
            showEasing: "swing",
            hideEasing: "linear",
            showDuration: 600,
            hideDuration: 300
        };

        // Flash session dari Laravel
        @if(Session::has('success'))
            toastr.success("🎉 {{ Session::get('success') }}", "Berhasil");
        @endif

        @if(Session::has('error'))
            toastr.error("😢 {{ Session::get('error') }}", "Gagal");
        @endif

        @if(Session::has('info'))
            toastr.info("ℹ️ {{ Session::get('info') }}", "Info");
        @endif

        @if(Session::has('warning'))
            toastr.warning("⚠️ {{ Session::get('warning') }}", "Peringatan");
        @endif
    </script>

</body>
</html>
