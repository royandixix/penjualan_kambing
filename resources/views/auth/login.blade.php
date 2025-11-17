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
            background: rgba(0,0,0,0.4);
            color: #fff;
        }

        #qr-reader {
            width: 100% !important;
        }
    </style>
</head>

<body class="d-flex align-items-center py-4">

    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <h1 class="h3 mb-4 fw-bold text-center">Silakan Login</h1>

            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" placeholder="Nama Pengguna" required autofocus>
                <label>Nama Pengguna</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <label>Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Login</button>
        </form>

        <div class="text-center mt-4">
            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#scanQrModal">
                Login dengan Scan QR
            </button>
        </div>

        <p class="text-center text-white mt-4">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>

        <p class="mt-5 mb-3 text-center text-white">&copy; Kamberu 2025</p>
    </main>

    <!-- Modal QR -->
    <div class="modal fade" id="scanQrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <h5 class="text-center mb-3 fw-bold">Scan QR Code Login</h5>
                <div id="qr-reader"></div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>

    <script>
        @if(Session::has('success')) toastr.success("{{ Session::get('success') }}"); @endif
        @if(Session::has('error')) toastr.error("{{ Session::get('error') }}"); @endif

        function onScanSuccess(decodedText) {
            fetch("{{ route('login.qr') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_token: decodedText })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    toastr.error(data.message || "QR Code tidak valid!");
                }
            })
            .catch(err => toastr.error("Error: " + err));
            
            html5QrcodeScanner.clear();
        }

        let html5QrcodeScanner;

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
