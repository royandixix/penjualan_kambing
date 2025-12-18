@extends('admin.layouts.app')

@section('title', 'Laporan Pesanan')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 fw-bold">
        <i class="bi bi-list-check"></i> Laporan Pesanan
    </h4>

    {{-- CETAK SEMUA --}}
    <div class="mb-3">
        <a href="{{ route('admin.laporan.pemesanan.cetak') }}"
           target="_blank"
           class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
        </a>

        <a href="{{ route('admin.laporan.pemesanan.excel') }}"
           target="_blank"
           class="btn btn-primary">
            <i class="bi bi-file-earmark-excel-fill"></i> Export Excel
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
                            <th>Aksi</th> {{-- 🔥 --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pesanans as $pesanan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $pesanan->user->name ?? '-' }}</td>
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
                            <td>
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                {{-- CETAK PER ITEM --}}
                                <a href="{{ route('admin.laporan.pemesanan.cetak.item', $pesanan->id) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-danger">
                                    Cetak
                                </a>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="6" class="bg-light small">
                                <strong class="text-primary">📝 Rincian Kambing:</strong>
                                <ul class="mb-0 ps-3">
                                    @forelse ($pesanan->detailPesanans as $detail)
                                        <li>
                                            {{ $detail->kambing->jenis_kambing ?? '-' }}
                                            — Jumlah: {{ $detail->jumlah }},
                                            Subtotal:
                                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </li>
                                    @empty
                                        <li class="text-muted fst-italic">Tidak ada rincian.</li>
                                    @endforelse
                                </ul>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada pesanan.
                            </td>
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
