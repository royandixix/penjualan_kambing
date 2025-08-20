@extends('admin.layouts.app')
@section('title', 'Detail Pembayaran Kambing')

@section('content')
<div class="container">
    <h4>Detail Pembayaran</h4>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Nama Pengguna:</strong> {{ $pembayaran->user->name }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $pembayaran->tanggal_pesan }}</p>
            <p><strong>Status:</strong> {{ ucfirst($pembayaran->status) }}</p>
            <p><strong>Total Harga:</strong> {{ $pembayaran->getTotalHargaFormattedAttribute() }}</p>
            <p><strong>Metode Bayar:</strong> {{ $pembayaran->metode_bayar }}</p>

            @if($pembayaran->bukti_bayar)
                <p><strong>Bukti Bayar:</strong></p>
                <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" width="200" alt="Bukti Bayar">
            @endif
        </div>
    </div>

    <h5>Detail Pesanan</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jenis Kambing</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pembayaran->detailPesanans as $detail)
                <tr>
                    <td>{{ optional($detail->kambing)->jenis_kambing ?? '-' }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp{{ number_format(optional($detail->kambing)->harga ?? 0, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    <td>
                        @if(optional($detail->kambing)->foto)
                            <img src="{{ asset('storage/' . $detail->kambing->foto) }}" width="100" alt="Foto Kambing">
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
