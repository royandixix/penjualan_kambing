<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

    <div class="card shadow p-4 text-center" style="max-width: 400px;">
        <h3 class="mb-3">Registrasi Berhasil 🎉</h3>
        <p>Halo <strong>{{ $user->name }}</strong>, akunmu sudah terdaftar.</p>

        <p>Ini adalah QR Code unik milikmu:</p>
        <img src="{{ $qrPath }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 250px;">

        <p class="text-muted" style="font-size: 14px;">
            Simpan QR ini, nanti bisa dipakai untuk login cepat.
        </p>

        <a href="{{ route('login') }}" class="btn btn-primary w-100">Login Sekarang</a>
    </div>

</body>
</html>
