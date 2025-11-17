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
            background-color: #ffffff;
        }

        :root {
            --primary-green: #2e7d32;   /* hijau utama */
            --light-green: #e8f5e9;     /* hijau muda */
            --soft-green: #c8e6c9;      /* hijau lembut */
            --pale-green: #f1f8e9;      /* hijau sangat muda */
        }

        h2 {
            text-align: center;
            margin-bottom: 15px;
            color: var(--primary-green);
            text-transform: uppercase;
            border-bottom: 3px solid var(--primary-green);
            padding-bottom: 6px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 30px;
            border: 1px solid #bbb;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: center;
            vertical-align: middle;
            font-size: 10.5px;
        }

        th {
            background-color: var(--light-green);
            color: var(--primary-green);
            font-weight: bold;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background-color: var(--pale-green);
        }

        tbody tr:hover {
            background-color: var(--soft-green);
            transition: background-color 0.2s ease-in-out;
        }

        .img-kambing, .img-bukti {
            height: 60px;
            width: auto;
            object-fit: cover;
            border-radius: 6px;
            display: block;
            margin: 3px auto;
            border: 1px solid var(--soft-green);
        }

        .footer {
            text-align: right;
            font-size: 10px;
            color: var(--primary-green);
            border-top: 2px solid var(--primary-green);
            padding-top: 5px;
            margin-top: 10px;
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
                    <td style="color: var(--primary-green); font-weight: bold;">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </td>
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
