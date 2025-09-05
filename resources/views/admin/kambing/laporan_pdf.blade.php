<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kambing</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        .text-left { text-align: left; }
    </style>
</head>
<body>
    <h3 style="text-align:center;">Laporan Daftar Kambing</h3>
    <p>Tanggal: {{ date('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Kambing</th>
                <th>Umur (bln)</th>
                <th>Berat (kg)</th>
                <th>Jenis Kelamin</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kambings as $index => $kambing)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $kambing->jenis_kambing }}</td>
                <td>{{ $kambing->umur }}</td>
                <td>{{ $kambing->berat }}</td>
                <td>{{ $kambing->jenis_kelamin }}</td>
                <td>Rp {{ number_format($kambing->harga,0,',','.') }}</td>
                <td>{{ $kambing->stok }}</td>
                <td class="text-left">{{ $kambing->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
