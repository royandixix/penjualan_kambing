@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Detail Pesanan</h4>

        <!-- Informasi Umum Pesanan -->
        <div class="card mb-4">
            <div class="card-header">
                Informasi Pemesanan
            </div>
            <div class="card-body">
                <p><strong>Nama Pembeli:</strong> {{ $pesanan->user->name ?? 'Tidak ditemukan' }}</p>
                <p><strong>Email:</strong> {{ $pesanan->user->email ?? '-' }}</p>
                <p><strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y') }}</p>
                <p><strong>Status:</strong>
                    <span class="badge {{ $pesanan->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                        {{ ucfirst($pesanan->status) }}
                    </span>
                </p>
                <p><strong>Total Harga:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Tabel Detail Pesanan -->
        <div class="card">
            <div class="card-header">
                Rincian Kambing yang Dipesan
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kambing</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan->detail_pesanans as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->kambing->nama ?? 'Data kambing tidak ditemukan' }}</td>
                                <td>{{ $detail->jumlah }}</td>
                                <td>Rp {{ number_format($detail->kambing->harga ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        @if ($pesanan->detail_pesanans->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada detail pesanan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-4">
            <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pesanan
            </a>
        </div>
    </div>
@endsection
