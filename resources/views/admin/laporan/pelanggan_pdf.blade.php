<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Data Pelanggan</title>
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
            --primary-color: #007f3f; /* hijau utama */
            --header-bg: #e9f9f0;    /* latar belakang hijau muda */
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
            border: 1px solid #d8e6da;
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
        <p>Telp: 085299006996 | Email: ternakkambing@email.com </p>
        <h2>LAPORAN DATA PELANGGAN</h2>
    </header>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th class="left" style="width: 20%;">Nama</th>
                <th class="left" style="width: 25%;">Email</th>
                <th class="center" style="width: 15%;">No HP</th>
                <th class="left" style="width: 35%;">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggans as $index => $p)
            <tr>
                <td class="center">{{ $index+1 }}</td>
                <td class="left">{{ $p->nama }}</td>
                <td class="left">{{ $p->email }}</td>
                <td class="center">{{ $p->no_hp }}</td>
                <td class="left">{{ $p->alamat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p class="print-info">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </p>
</body>
</html>
