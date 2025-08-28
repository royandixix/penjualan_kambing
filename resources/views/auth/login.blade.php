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

        #qr-reader {
            width: 100% !important;
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
        </form>

        {{-- Login via QR --}}
        <div class="text-center mt-4">
            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#scanQrModal">
                Login dengan Scan QR
            </button>
        </div>

        {{-- Link ke Register --}}
        <p class="text-center text-white mt-4">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>

        <p class="mt-5 mb-3 text-center text-white">&copy; Kamberu 2025</p>
    </main>

    <!-- Modal Kamera untuk Scan QR -->
    <div class="modal fade" id="scanQrModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
          <h5 class="text-center mb-3">Scan QR Code dari WhatsApp</h5>
          <div id="qr-reader"></div>
        </div>
      </div>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        // Toastr Config
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

        // Flash dari Laravel
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

        // QR Scanner
        function onScanSuccess(decodedText, decodedResult) {
            fetch("{{ route('login.qr') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_token: decodedText })
            })
            .then(res => {
                if (res.redirected) {
                    window.location.href = res.url;
                } else {
                    toastr.error("QR Code tidak valid!", "Gagal");
                }
            })
            .catch(err => toastr.error("Error: " + err, "Gagal"));

            html5QrcodeScanner.clear(); // stop kamera setelah dapat QR
        }

        var html5QrcodeScanner;
        document.getElementById('scanQrModal').addEventListener('shown.bs.modal', function () {
            html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", { fps: 10, qrbox: 250 });
            html5QrcodeScanner.render(onScanSuccess);
        });

        document.getElementById('scanQrModal').addEventListener('hidden.bs.modal', function () {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
        });
    </script>

</body>
</html>
