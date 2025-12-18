@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<style>
    .container-fluid {
        padding: 2rem;
    }
    h4.mb-4 {
        font-weight: bold;
    }
    .badge-success { background-color: #28a745; }
    .badge-warning { background-color: #ffc107; color: #000; }
    .badge-danger { background-color: #dc3545; }
</style>

<div class="container-fluid">
    <h4 class="mb-4">Daftar Penjualan</h4>

    {{-- CETAK SEMUA --}}
    <a href="{{ route('admin.laporan.penjualan.cetak') }}" target="_blank" class="btn btn-danger mb-3">
        <i class="bi bi-file-earmark-pdf"></i> Export PDF
    </a>

    <a href="{{ route('admin.laporan.penjualan.excel') }}" class="btn btn-primary mb-3 ms-2">
        <i class="bi bi-file-earmark-excel"></i> Export Excel
    </a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Kambing</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Jual</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans as $index => $penjualan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @foreach ($penjualan->detailPesanans as $detail)
                            {{ $detail->kambing->jenis_kambing ?? '-' }}
                            @if (!$loop->last), @endif
                        @endforeach
                    </td>
                    <td>{{ $penjualan->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_pesan)->format('d M Y') }}</td>
                    <td>
                        @if ($penjualan->status == 'lunas')
                            <span class="badge badge-success">Lunas</span>
                        @elseif ($penjualan->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">{{ ucfirst($penjualan->status) }}</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                    <td>
                        {{-- CETAK PER ITEM --}}
                        <a href="{{ route('admin.laporan.penjualan.cetak.item', $penjualan->id) }}"
                           target="_blank"
                           class="btn btn-sm btn-danger mb-1">
                            Cetak
                        </a>

                        {{-- DETAIL --}}
                        <button class="btn btn-sm btn-info btn-detail"
                            data-bs-toggle="modal"
                            data-bs-target="#detailModal"
                            data-user="{{ $penjualan->user->name }}"
                            data-tanggal="{{ \Carbon\Carbon::parse($penjualan->tanggal_pesan)->format('d M Y') }}"
                            data-status="{{ ucfirst($penjualan->status) }}"
                            data-total="Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}"
                            data-metode="{{ ucfirst($penjualan->metode_bayar) }}"
                            data-detail='@json($penjualan->detailPesanans)'>
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-muted">Belum ada data penjualan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Penjualan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> <span id="modal-user"></span></p>
                <p><strong>Tanggal:</strong> <span id="modal-tanggal"></span></p>
                <p><strong>Status:</strong> <span id="modal-status"></span></p>
                <p><strong>Total:</strong> <span id="modal-total"></span></p>
                <p><strong>Metode:</strong> <span id="modal-metode"></span></p>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="modal-detail-table"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-detail').forEach(btn => {
    btn.addEventListener('click', () => {
        document.getElementById('modal-user').innerText = btn.dataset.user;
        document.getElementById('modal-tanggal').innerText = btn.dataset.tanggal;
        document.getElementById('modal-status').innerText = btn.dataset.status;
        document.getElementById('modal-total').innerText = btn.dataset.total;
        document.getElementById('modal-metode').innerText = btn.dataset.metode;

        const tbody = document.getElementById('modal-detail-table');
        tbody.innerHTML = '';

        JSON.parse(btn.dataset.detail).forEach(item => {
            tbody.innerHTML += `
                <tr>
                    <td>${item.kambing?.jenis_kambing ?? '-'}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${Number(item.subtotal).toLocaleString('id-ID')}</td>
                </tr>`;
        });
    });
});
</script>
@endpush
