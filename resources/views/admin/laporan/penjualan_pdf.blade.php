<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Kambing</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 25px;
            padding: 0;
            line-height: 1.5;
        }

        :root {
            --primary-color: #007f3f;   /* Hijau utama */
            --header-bg: #e9f9f0;       /* Hijau muda */
            --footer-bg: #d6f5df;       /* Hijau lembut */
            --highlight-bg: #f2fff6;    /* Hijau sangat muda */
        }

        header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 4px solid var(--primary-color);
            padding-bottom: 15px;
        }

        header h1 {
            margin: 0;
            font-size: 26pt;
            color: var(--primary-color);
            font-weight: 800;
            text-transform: uppercase;
        }

        header p {
            margin: 3px 0 0 0;
            font-size: 10pt;
            color: #555;
        }

        header h2 {
            font-size: 18pt;
            margin: 20px 0 0;
            font-weight: 700;
            color: var(--primary-color);
            border-bottom: 1px dashed #ccc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border: 1px solid #ccc;
        }

        th, td {
            border: 1px solid #dceedd;
            padding: 8px 10px;
            text-align: left;
            vertical-align: top;
            font-size: 10pt;
        }

        th {
            background-color: var(--header-bg);
            color: var(--primary-color);
            font-weight: 700;
            font-size: 10pt;
            text-transform: uppercase;
            text-align: center;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9fff9;
        }

        .right { text-align: right; }
        .center { text-align: center; }
        .left { text-align: left; }

        .total-col {
            font-weight: 700;
            text-align: right;
            background-color: var(--highlight-bg);
            color: var(--primary-color);
        }

        th.total-col {
            background-color: var(--header-bg);
            color: var(--primary-color);
        }

        tfoot td {
            background-color: var(--footer-bg);
            color: var(--primary-color);
            font-weight: bold;
            font-size: 11pt;
            border-top: 3px solid var(--primary-color);
        }

        .print-info {
            margin-top: 10px;
            text-align: left;
            font-size: 9pt;
            color: #555;
        }
    </style>
</head>

<body>
    <header>
        <h1>TERNAK KAMBING</h1>
        <p>Jl. Tani, No.62, Kec. Belopa, Kab. Luwu</p>
        <p>Telp: 085299006996 | Email: ternakkambing@email.com  </p>
        <h2>LAPORAN PENJUALAN</h2>
    </header>

    <p class="print-info">
        Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}
    </p>

    <table>
        <thead>
            <tr>
                <th class="center" style="width: 5%;">No</th>
                <th class="left" style="width: 25%;">Nama Pelanggan</th>
                <th class="left" style="width: 35%;">Detail Produk</th>
                <th class="center" style="width: 15%;">Tanggal Jual</th>
                <th class="center" style="width: 10%;">Status</th>
                <th class="right total-col" style="width: 10%;">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($penjualans as $index => $penjualan)
                @php $grandTotal += $penjualan->total_harga; @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="left">{{ $penjualan->user->name ?? '-' }}</td>
                    <td class="left" style="font-size: 9pt;">
                        @if(isset($penjualan->detailPesanans) && $penjualan->detailPesanans->count())
                            @foreach($penjualan->detailPesanans as $detail)
                                {{ $detail->kambing->jenis_kambing ?? 'Produk Dihapus' }} (x{{ $detail->jumlah }} ekor)<br>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td class="center">{{ \Carbon\Carbon::parse($penjualan->tanggal_pesan)->format('d/m/Y') }}</td>
                    <td class="center">{{ ucfirst($penjualan->status) }}</td>
                    <td class="right total-col">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>

        @if(count($penjualans) > 0)
        <tfoot>
            <tr>
                <td colspan="5" class="right">TOTAL KESELURUHAN</td>
                <td class="right total-col">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</body>
</html>
