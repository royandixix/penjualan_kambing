<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemesanan</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            color: #333;
            margin: 10px 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
            color: #2c3e50;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .img-kambing, .img-bukti {
            height: 60px;
            width: auto;
            object-fit: cover;
            border-radius: 4px;
            display: block;
            margin: 3px auto;
        }

        .footer {
            text-align: right;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    <h2>Laporan Pemesanan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Pesan</th>
                <th>Gambar Kambing</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Metode Bayar</th>
                <th>Bukti Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanans as $index => $pesanan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pesanan->user->name ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d-m-Y') }}</td>
                    <td style="text-align: left;">
                        @forelse ($pesanan->detailPesanans as $detail)
                            @if ($detail->kambing && $detail->kambing->foto)
                                @php
                                    $fotoPath = public_path('storage/' . $detail->kambing->foto);
                                @endphp
                                @if(file_exists($fotoPath))
                                    <img src="{{ $fotoPath }}" alt="Kambing" class="img-kambing">
                                @else
                                    <span>-</span>
                                @endif
                            @else
                                <span>-</span>
                            @endif
                        @empty
                            <span>-</span>
                        @endforelse
                    </td>
                    <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($pesanan->status) }}</td>
                    <td>{{ $pesanan->metode_bayar ?? '-' }}</td>
                    <td>
                        @php
                            $buktiPath = public_path('storage/' . $pesanan->bukti_bayar);
                        @endphp
                        @if ($pesanan->bukti_bayar && file_exists($buktiPath))
                            <img src="{{ $buktiPath }}" class="img-bukti" alt="Bukti Bayar">
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}
    </div>

</body>
</html>
