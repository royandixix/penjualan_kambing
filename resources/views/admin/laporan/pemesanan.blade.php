@extends('admin.layouts.app')

@section('title', 'Laporan Pesanan')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 fw-bold"><i class="bi bi-list-check"></i> Laporan Pesanan</h4>

    {{-- Tombol Export PDF --}}
    <div class="mb-3">
        <a href="{{ route('admin.laporan.pemesanan.cetak') }}" target="_blank" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Pembeli</th>
                            <th>Tanggal Pesan</th>
                            <th>Status</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanans as $pesanan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $pesanan->user->name ?? 'Tidak ditemukan' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y') }}</td>
                            <td class="text-center">
                                @php
                                    $badgeClass = match ($pesanan->status) {
                                        'pending' => 'bg-warning text-dark',
                                        'selesai' => 'bg-success',
                                        'ditolak' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge rounded-pill {{ $badgeClass }}">
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" class="bg-light small">
                                <strong class="text-primary">📝 Rincian Jenis Kambing:</strong>
                                <ul class="mb-0 ps-3">
                                    @forelse ($pesanan->detailPesanans as $detail)
                                    <li>
                                        <span class="fw-semibold">{{ $detail->kambing->jenis ?? '-' }}</span>
                                        - Jumlah: <strong>{{ $detail->jumlah }}</strong>,
                                        Subtotal: <strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                                    </li>
                                    @empty
                                    <li class="text-muted fst-italic">Tidak ada rincian.</li>
                                    @endforelse

                                    @if ($pesanan->bukti_bayar && file_exists(storage_path('app/public/bukti_bayar/' . $pesanan->bukti_bayar)))
                                    <li>
                                        <strong>Bukti Bayar:</strong>
                                        <a href="{{ asset('storage/bukti_bayar/' . $pesanan->bukti_bayar) }}" target="_blank">Lihat Bukti</a>
                                    </li>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $pesanans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
