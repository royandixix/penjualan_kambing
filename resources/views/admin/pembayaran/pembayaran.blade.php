@extends('admin.layouts.app')

@section('title', 'Pembayaran Kambing')

@section('content')
    <style>
        .container-fluid {
            padding: 2rem;
        }

        h4.mb-4 {
            font-weight: bold;
            color: #212529;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table td,
        .table th {
            vertical-align: middle;
            color: #212529;
        }

        .text-muted {
            color: #6c757d !important;
        }
    </style>

    <div class="container-fluid">
        <h4 class="mb-4">Daftar Pembayaran Kambing</h4>

        {{-- <div class="mb-3">
        <a href="{{ route('admin.pembayaran.tambah') }}" class="btn btn-primary align-items-center gap-1">
            <i class="mdi mdi-credit-card-plus-outline"></i> Tambah Pembayaran
        </a>
    </div> --}}
<!-- 
    <a href="{{ route('admin.pembayaran.cetak_pdf') }}" target="_blank" class="btn btn-danger">
        <i class="mdi mdi-file-pdf"></i> Cetak PDF
    </a>
     -->
    

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Jenis Kambing</th> {{-- ✅ Tambahan --}}
                        <th>Tanggal Pesan</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $index => $pembayaran)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pembayaran->user->name }}</td>
                            <td>
                                @foreach ($pembayaran->detailPesanans as $detail)
                                    {{ $detail->kambing->jenis_kambing ?? '-' }} ({{ $detail->jumlah }} ekor)<br>
                                @endforeach
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pesan)->format('d M Y') }}</td>
                            <td>{{ ucfirst($pembayaran->status) }}</td>
                            <td>Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info btn-detail" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" data-user="{{ $pembayaran->user->name }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($pembayaran->tanggal_pesan)->format('d M Y') }}"
                                    data-status="{{ ucfirst($pembayaran->status) }}"
                                    data-total="Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}"
                                    data-metode="{{ ucfirst($pembayaran->metode_bayar) }}"
                                    data-detail='@json($pembayaran->detailPesanans)'>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    {{-- Modal Tunggal --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Pengguna:</strong> <span id="modal-user"></span></p>
                    <p><strong>Tanggal Pesan:</strong> <span id="modal-tanggal"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                    <p><strong>Total Harga:</strong> <span id="modal-total"></span></p>
                    <p><strong>Metode Bayar:</strong> <span id="modal-metode"></span></p>

                    <h6 class="mt-3">Detail Pesanan</h6>
                    <table class="table table-bordered" id="modal-detail-table">
                        <thead>
                            <tr>
                                <th>Jenis Kambing</th>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailModal = document.getElementById('detailModal');
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
                        <td>${item.kambing ? item.kambing.jenis_kambing : '-'}</td>
                        <td>${item.jumlah}</td>
                        <td>Rp ${Number(item.subtotal).toLocaleString('id-ID')}</td>
                    </tr>
                `;
                    });
                });
            });
        });
    </script>
@endsection
