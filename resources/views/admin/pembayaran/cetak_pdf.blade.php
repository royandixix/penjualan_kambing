<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembayaran Kambing</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }
        th {
            background: #f2f2f2;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h2>Laporan Pembayaran Kambing</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Jenis Kambing</th>
                <th>Tanggal Pesan</th>
                <th>Status</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayarans as $index => $pembayaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pembayaran->user->name }}</td>
                    <td>
                        @foreach ($pembayaran->detailPesanans as $detail)
                            {{ $detail->kambing->jenis_kambing ?? '-' }} ({{ $detail->jumlah }} ekor)<br>
                        @endforeach
                    </td>
                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pesan)->format('d M Y') }}</td>
                    <td>{{ ucfirst($pembayaran->status) }}</td>
                    <td class="text-right">Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data pembayaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
