<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Pelanggan</title>

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
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h3 {
            margin: 0;
            color: var(--primary-green);
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        /* JUDUL */
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
            border: 1px solid #bbb;
        }

        td {
            border: 1px solid #ccc;
            padding: 8px 10px;
            font-size: 11px;
        }

        td.label {
            width: 30%;
            background-color: var(--light-green);
            font-weight: bold;
            color: var(--primary-green);
        }

        td.value {
            width: 70%;
        }

        /* FOOTER */
        .footer {
            text-align: right;
            font-size: 10px;
            color: var(--primary-green);
            margin-top: 20px;
            border-top: 2px solid var(--primary-green);
            padding-top: 5px;
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

    <!-- JUDUL -->
    <div class="title">
        Laporan Data Pelanggan
    </div>

    <!-- ISI DATA -->
    <table>
        <tr>
            <td class="label">Nama</td>
            <td class="value">{{ $pelanggan->nama }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td class="value">{{ $pelanggan->email }}</td>
        </tr>
        <tr>
            <td class="label">No. HP</td>
            <td class="value">{{ $pelanggan->no_hp }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="value">{{ $pelanggan->alamat }}</td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>
