<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Kamberu</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Toastr CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- Style tambahan --}}
    <style>
        html, body {
            height: 100%;
        }
        .form-signin {
            max-width: 330px;
            padding: 1rem;
            margin: auto;
        }
        .form-signin .form-floating:focus-within {
            z-index: 2;
        }
        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }
    </style>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">

<main class="form-signin w-100 m-auto">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h1 class="h3 mb-3 fw-normal text-center">Silakan Login</h1>

        {{-- Email Input --}}
        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required autofocus>
            <label for="floatingInput">Email address</label>
        </div>

        {{-- Password Input --}}
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>

        {{-- Error Message (jika ada) --}}
        @if(session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}
            </div>
        @endif

        <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Login</button>

        <p class="mt-3 text-center">
            Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </p>

        <p class="mt-5 mb-3 text-muted text-center">&copy; Kamberu 2025</p>
    </form>
</main>

{{-- jQuery (dibutuhkan oleh Toastr) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Toastr JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    #toast-container {
        bottom: 50px !important;
        top: 100px !important;
        left: 100px% !important;
        transform: translateX(-50%) !important;
    }
</style>

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
