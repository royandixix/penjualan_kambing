<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>QR Login WhatsApp</title>
</head>

<body>

    <h2>QR WhatsApp untuk {{ $user->name }}</h2>

    <center>
        {!! $qrSvg !!}
    </center>

    <br>

    <center>
        <a href="https://wa.me/{{ $user->no_hp }}" target="_blank"
           style="padding: 10px 15px; background: green; color: white; 
                  border-radius: 6px; text-decoration:none;">
            Buka WhatsApp Chat
        </a>
    </center>

</body>
</html>
