@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<style>
    .container-fluid { padding: 2rem; }
    h4.mb-4 { font-weight: bold; color: #212529; }
    .badge-success { background-color: #28a745; }
    .badge-warning { background-color: #ffc107; color: #000; }
    .badge-danger { background-color: #dc3545; }
    .badge-secondary { background-color: #6c757d; }
    .table-responsive { overflow-x: auto; }
    .table td, .table th { vertical-align: middle; color: #212529; }
    .text-muted { color: #6c757d !important; }
    ul { padding-left: 1.2rem; }
</style>

<div class="container-fluid">
    <h4 class="mb-4">Laporan Penjualan</h4>

    <a href="{{ route('admin.laporan.penjualan.cetak') }}" target="_blank" class="btn btn-success mb-3">
        <i class="mdi mdi-file-pdf-outline"></i> Export PDF
    </a>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>Tanggal Pesan</th>
                    <th>Status</th>
                    <th>Rincian Pesanan</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans as $index => $penjualan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penjualan->user->name ?? 'Tidak ditemukan' }}</td>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_pesan)->format('d M Y') }}</td>
                    <td>
                        @if($penjualan->status == 'selesai')
                            <span class="badge badge-success">{{ ucfirst($penjualan->status) }}</span>
                        @elseif($penjualan->status == 'pending')
                            <span class="badge badge-warning">{{ ucfirst($penjualan->status) }}</span>
                        @elseif($penjualan->status == 'ditolak')
                            <span class="badge badge-danger">{{ ucfirst($penjualan->status) }}</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($penjualan->status) }}</span>
                        @endif
                    </td>
                    <td class="text-start">
                        <ul class="mb-0">
                            @forelse ($penjualan->detailPesanans as $detail)
                                <li>
                                    {{ $detail->kambing->jenis ?? '-' }} 
                                    (x{{ $detail->jumlah }}) 
                                    - Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </li>
                            @empty
                                <li class="text-muted fst-italic">Tidak ada rincian.</li>
                            @endforelse

                            @if ($penjualan->bukti_bayar && file_exists(storage_path('app/public/bukti_bayar/' . $penjualan->bukti_bayar)))
                                <li>
                                    <strong>Bukti Bayar:</strong>
                                    <a href="{{ asset('storage/bukti_bayar/' . $penjualan->bukti_bayar) }}" target="_blank">
                                        Lihat Bukti
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </td>
                    <td><strong>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada penjualan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Kalau pakai paginate di controller --}}
        @if(method_exists($penjualans, 'links'))
            <div class="mt-3">
                {{ $penjualans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection