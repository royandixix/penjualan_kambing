<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan Kambing</title>
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
            --primary-color: #004d99;
            --header-bg: #eaf6ff;
            --highlight-bg: #fffacd;
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
            margin-top: 20px;
            border: 1px solid #ccc;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 8px 10px;
            text-align: left;
            vertical-align: middle;
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
            background-color: #fcfcfc;
        }

        .right { text-align: right; }
        .center { text-align: center; }
        .left { text-align: left; }

        .total-col {
            font-weight: 700;
            text-align: right;
            background-color: var(--highlight-bg);
        }
        th.total-col {
            background-color: var(--header-bg);
            color: #d9534f;
        }

        .print-info {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
            color: #777;
        }
    </style>
</head>
<body>
    <header>
        <h1>TERNAK KAMBING</h1>
        <p>Jl. Tani, No.62, Kec. Belopa, Kan. Luwu</p>
        <p>Telp: 085299006996 | Email: ternakkambing@email.com (Contoh)</p>
        <h2>LAPORAN DATA PESANAN</h2>
    </header>
    
    <table>
        <thead>
            <tr>
                <th class="center" style="width: 5%;">No</th>
                <th class="left" style="width: 35%;">Nama Pembeli</th>
                <th class="center" style="width: 20%;">Tanggal Pesan</th>
                <th class="center" style="width: 15%;">Status</th>
                <th class="right total-col" style="width: 25%;">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($pesanans as $pesanan)
                @php $grandTotal += $pesanan->total_harga; @endphp
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td class="left">{{ $pesanan->user->name ?? '-' }}</td>
                    <td class="center">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}</td>
                    <td class="center">{{ ucfirst($pesanan->status) }}</td>
                    <td class="right total-col">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        
        @if(count($pesanans) > 0)
        <tfoot>
            <tr>
                <td colspan="4" class="right" style="border-top: 3px solid var(--primary-color); background-color: #e6f7ff; color: var(--primary-color); font-weight: bold; font-size: 11pt;">TOTAL KESELURUHAN</td>
                <td class="right total-col" style="border-top: 3px solid var(--primary-color);">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
    
    <p class="print-info">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </p>
</body>
</html>
