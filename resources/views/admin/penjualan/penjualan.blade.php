@extends('admin.layouts.app')

@section('title', 'Daftar Penjualan')

@section('content')
<style>
    .container-fluid { padding: 2rem; }
    h4.mb-4 { font-weight: bold; color: #212529; }
    .badge-success { background-color: #28a745; }
    .badge-warning { background-color: #ffc107; color: #000; }
    .badge-danger { background-color: #dc3545; }
    .table-responsive { overflow-x: auto; }
    .table td, .table th { vertical-align: middle; color: #212529; }
    .text-muted { color: #6c757d !important; }
</style>

<div class="container-fluid">
    <h4 class="mb-4">Daftar Penjualan</h4>

    <div class=" contrast-more: min-[]:">
        
    </div>


  

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Jual</th>
                    <th>Status</th>
                    <th>Total Penjualan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penjualans
                 as $index => $penjualan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penjualan->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal_jual)->format('d M Y') }}</td>
                    <td>
                        @if($penjualan->status == 'lunas')
                            <span class="badge badge-success">{{ ucfirst($penjualan->status) }}</span>
                        @elseif($penjualan->status == 'pending')
                            <span class="badge badge-warning">{{ ucfirst($penjualan->status) }}</span>
                        @else
                            <span class="badge badge-danger">{{ ucfirst($penjualan->status) }}</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info btn-detail"
                            data-bs-toggle="modal"
                            data-bs-target="#detailModal"
                            data-user="{{ $penjualan->user->name }}"
                            data-tanggal="{{ \Carbon\Carbon::parse($penjualan->tanggal_jual)->format('d M Y') }}"
                            data-status="{{ ucfirst($penjualan->status) }}"
                            data-total="Rp {{ number_format($penjualan->total_harga,0,',','.') }}"
                            data-metode="{{ ucfirst($penjualan->metode_bayar) }}"
                            data-detail='@json($penjualan->detailPenjualans)'>
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data penjualan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Detail Penjualan --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Penjualan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Nama Pelanggan:</strong> <span id="modal-user"></span></p>
        <p><strong>Tanggal Jual:</strong> <span id="modal-tanggal"></span></p>
        <p><strong>Status:</strong> <span id="modal-status"></span></p>
        <p><strong>Total Penjualan:</strong> <span id="modal-total"></span></p>
        <p><strong>Metode Bayar:</strong> <span id="modal-metode"></span></p>

        <h6 class="mt-3">Detail Produk</h6>
        <table class="table table-bordered" id="modal-detail-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalUser = document.getElementById('modal-user');
    const modalTanggal = document.getElementById('modal-tanggal');
    const modalStatus = document.getElementById('modal-status');
    const modalTotal = document.getElementById('modal-total');
    const modalMetode = document.getElementById('modal-metode');
    const modalDetailTable = document.querySelector('#modal-detail-table tbody');

    document.querySelectorAll('.btn-detail').forEach(button => {
        button.addEventListener('click', () => {
            modalUser.textContent = button.dataset.user;
            modalTanggal.textContent = button.dataset.tanggal;
            modalStatus.textContent = button.dataset.status;
            modalTotal.textContent = button.dataset.total;
            modalMetode.textContent = button.dataset.metode;

            const details = JSON.parse(button.dataset.detail);
            modalDetailTable.innerHTML = '';

            details.forEach(item => {
                modalDetailTable.innerHTML += `
                    <tr>
                        <td>${item.produk ? item.produk.nama : '-'}</td>
                        <td>${item.jumlah}</td>
                        <td>Rp ${Number(item.subtotal).toLocaleString('id-ID')}</td>
                    </tr>
                `;
            });
        });
    });
});
</script>
@endpush
