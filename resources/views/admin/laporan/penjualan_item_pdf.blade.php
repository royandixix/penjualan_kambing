<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>

    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
            color: #333;
            margin: 20px 30px;
            background-color: #ffffff;
        }

        :root {
            --primary-green: #2e7d32;
            --light-green: #e8f5e9;
            --soft-green: #c8e6c9;
            --pale-green: #f1f8e9;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: var(--primary-green);
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        /* TITLE */
        .title {
            text-align: center;
            margin: 15px 0 20px;
            font-size: 14px;
            font-weight: bold;
            color: var(--primary-green);
            border-top: 3px solid var(--primary-green);
            border-bottom: 3px solid var(--primary-green);
            padding: 6px 0;
            text-transform: uppercase;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #bbb;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 7px 9px;
            font-size: 11px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: var(--light-green);
            color: var(--primary-green);
            font-weight: bold;
            text-transform: uppercase;
        }

        td.label {
            background-color: var(--light-green);
            font-weight: bold;
            color: var(--primary-green);
            width: 30%;
            text-align: left;
        }

        td.value {
            width: 70%;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: var(--pale-green);
        }

        /* FOOTER */
        .footer {
            text-align: right;
            font-size: 10px;
            color: var(--primary-green);
            border-top: 2px solid var(--primary-green);
            padding-top: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <h3>TERNAK KAMBING</h3>
        <p>Jl. Tani, No.62, Kec. Belopa, Kab. Luwu</p>
        <p>Email: info@ternakkambing.com</p>
    </div>

    <!-- TITLE -->
    <div class="title">
        Laporan Data Penjualan
    </div>

    <!-- DATA PENJUALAN -->
    <table>
        <tr>
            <td class="label">Nama Pelanggan</td>
            <td class="value">{{ $penjualan->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Jual</td>
            <td class="value">
                {{ \Carbon\Carbon::parse($penjualan->tanggal_pesan)->format('d/m/Y') }}
            </td>
        </tr>
        <tr>
            <td class="label">Status</td>
            <td class="value">{{ ucfirst($penjualan->status) }}</td>
        </tr>
        <tr>
            <td class="label">Metode Bayar</td>
            <td class="value">{{ ucfirst($penjualan->metode_bayar) }}</td>
        </tr>
        <tr>
            <td class="label">Total Penjualan</td>
            <td class="value" style="font-weight:bold;color:var(--primary-green);">
                Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <!-- DETAIL -->
    <div class="title" style="font-size:12px;">
        Detail Penjualan
    </div>

    <table>
        <thead>
            <tr>
                <th>Jenis Kambing</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan->detailPesanans as $detail)
                <tr>
                    <td>{{ $detail->kambing->jenis_kambing ?? '-' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
