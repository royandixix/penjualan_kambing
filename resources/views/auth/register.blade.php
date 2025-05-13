<!DOCTYPE html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Sistem Penjualan Kambing</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        html, body {
            height: 100%;
        }
        .form-register {
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }
        .form-register .form-floating:focus-within {
            z-index: 2;
        }
    </style>
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">

<main class="form-register w-100 m-auto">
    <h1 class="h3 mb-3 fw-normal text-center">Form Registrasi</h1>

    <!-- Alert sukses -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Alert error validasi -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-floating mb-2">
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="floatingName" placeholder="Nama Lengkap" required>
            <label for="floatingName">Nama Lengkap</label>
        </div>

        <div class="form-floating mb-2">
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="floatingEmail" placeholder="email@example.com" required>
            <label for="floatingEmail">Email</label>
        </div>

        <div class="form-floating mb-2">
            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-floating mb-2">
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="form-control" id="floatingNoHp" placeholder="No HP">
            <label for="floatingNoHp">No HP</label>
        </div>

        <div class="form-floating mb-2">
            <textarea name="alamat" class="form-control" id="floatingAlamat" placeholder="Alamat" style="height: 80px">{{ old('alamat') }}</textarea>
            <label for="floatingAlamat">Alamat</label>
        </div>

        <div class="form-floating mb-2">
            <input type="password" name="password_confirmation" class="form-control" id="floatingConfirm" placeholder="Konfirmasi Password" required>
            <label for="floatingConfirm">Konfirmasi Password</label>
        </div>

        <div class="form-floating mb-3">
            <select name="role" class="form-select" id="floatingRole" required>
                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Peran</option>
                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Pembeli" {{ old('role') == 'Pembeli' ? 'selected' : '' }}>Pembeli</option>
            </select>
            <label for="floatingRole">Peran</label>
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Daftar</button>

        <p class="mt-3 mb-1 text-body-secondary text-center">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </p>
    </form>
</main>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
