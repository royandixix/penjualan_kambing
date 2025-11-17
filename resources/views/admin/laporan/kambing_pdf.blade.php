<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Data Kambing</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 10pt;
            color: #333;
            margin: 25px;
            padding: 0;
            line-height: 1.5;
            background-color: #fff;
        }

        :root {
            --primary-color: #2e7d32; /* Hijau utama */
            --header-bg: #e8f5e9;     /* Hijau muda */
            --highlight-bg: #f1f8e9;  /* Hijau sangat muda */
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
            text-align: center;
            vertical-align: top;
            font-size: 10pt;
        }

        th {
            background-color: var(--header-bg);
            color: var(--primary-color);
            font-weight: 700;
            font-size: 10pt;
            text-transform: uppercase;
        }

        tbody tr:nth-child(odd) {
            background-color: #fafafa;
        }

        tbody tr:hover {
            background-color: var(--highlight-bg);
            transition: background-color 0.2s ease-in-out;
        }

        .right { text-align: right; }
        .center { text-align: center; }
        .left { text-align: left; }

        .data-col {
            text-align: right;
            background-color: var(--highlight-bg);
            color: var(--primary-color);
            font-weight: bold;
        }

        .data-col-center {
            text-align: center;
            background-color: var(--highlight-bg);
            color: var(--primary-color);
            font-weight: bold;
        }

        .print-info {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
            color: var(--primary-color);
            border-top: 2px solid var(--primary-color);
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>TERNAK KAMBING</h1>
        <p>Jl. Tani, No.62, Kec. Belopa, Kab. Luwu</p>
        <p>Email: info@ternakkambing.com </p>
        <h2>LAPORAN DATA KAMBING</h2>
    </header>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th class="left" style="width: 15%;">Jenis</th>
                <th style="width: 8%;">Umur</th>
                <th style="width: 8%;">Berat (Kg)</th>
                <th style="width: 10%;">Kelamin</th>
                <th class="right data-col" style="width: 15%;">Harga</th>
                <th class="data-col-center" style="width: 8%;">Stok</th>
                <th class="left" style="width: 31%;">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kambings as $i => $kambing)
            <tr>
                <td class="center">{{ $i+1 }}</td>
                <td class="left">{{ $kambing->jenis_kambing }}</td>
                <td class="center">{{ $kambing->umur }}</td>
                <td class="center">{{ $kambing->berat }}</td>
                <td class="center">{{ $kambing->jenis_kelamin }}</td>
                <td class="right data-col">Rp {{ number_format($kambing->harga,0,',','.') }}</td>
                <td class="center data-col-center">{{ $kambing->stok }}</td>
                <td class="left" style="font-size: 9pt;">{{ $kambing->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="print-info">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </p>
</body>
</html>
