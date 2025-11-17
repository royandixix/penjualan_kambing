<!DOCTYPE html>
<html>
<head>
    <title>QR Kambing_Kamberu</title>
</head>
<body>
    <h2>Halo {{ $user->name }}, selamat datang di Kambing_Kamberu!</h2>
    <p>Gunakan QR berikut untuk login:</p>
    {!! $qrSvg !!}
</body>
</html>
