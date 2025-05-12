<!doctype html>
<html lang="id" data-bs-theme="auto">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Penjualan Kambing</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-signin {
      max-width: 360px;
      padding: 15px;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }

    .btn {
      transition: background-color 0.3s ease, transform 0.2s ease;
      list-style: none
    }

    .btn:hover {
      transform: scale(1.03);
    }

    .form-control {
      transition: box-shadow 0.3s ease;
      font-size: 0.9rem;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    h1 {
      font-size: 1.5rem;
    }

    .text-body-secondary {
      font-size: 0.8rem;
    }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
  <main class="form-signin text-center">
    <form method="POST" action="{{ route('register') }}">
      @csrf

      {{-- <img class="mb-3" src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="60" height="50">
      <h1 class="mb-3 fw-normal">Daftar Akun</h1> --}}

      <div class="form-floating mb-2">
        <input type="text" name="name" class="form-control" id="floatingName" placeholder="Nama Lengkap" required>
        <label for="floatingName">Nama Lengkap</label>
      </div>

      <div class="form-floating mb-2">
        <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="email@example.com" required>
        <label for="floatingEmail">Alamat Email</label>
      </div>

      <div class="form-floating mb-2">
        <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>

      {{-- <div class="form-floating mb-2">
        <select name="role" class="form-select" id="floatingRole" required>
          <option value="" disabled selected>Pilih Peran</option>
          <option value="Pembeli">Pembeli</option>
          <option value="Admin">Admin</option>
        </select>
        <label for="floatingRole">Peran</label>
      </div> --}}

      <div class="form-floating mb-2">
        <input type="password" name="password_confirmation" class="form-control" id="floatingConfirm" placeholder="Konfirmasi Password" required>
        <label for="floatingConfirm">Konfirmasi Password</label>
      </div>

      @if ($errors->any())
        <div class="alert alert-danger mt-2">
          {{ $errors->first() }}
        </div>
      @endif

      <button class="btn btn-success w-100 py-2 mt-2" type="submit">Daftar</button>
      <p class="mt-3">Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
      <p class="mt-3 mb-1 text-body-secondary">&copy; 2025 Penjualan Kambing</p>
    </form>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
