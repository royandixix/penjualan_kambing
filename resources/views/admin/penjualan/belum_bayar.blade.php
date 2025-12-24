@extends('admin.layouts.app')

@section('title', 'Penjualan Belum Bayar')

@section('content')
<div class="container-fluid">
    <h4>Daftar Penjualan Belum Bayar</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Detail Produk</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penjualans as $index => $penjualan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penjualan->user->name ?? '-' }}</td>
                    <td>
                        @foreach($penjualan->detailPesanans as $detail)
                            {{ $detail->kambing->nama ?? '-' }} x {{ $detail->jumlah }}<br>
                        @endforeach
                    </td>
                    <td>{{ $penjualan->status }}</td>
                    <td>{{ number_format($penjualan->total, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada penjualan belum bayar</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
 