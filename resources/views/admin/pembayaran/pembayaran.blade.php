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
        /* Warna hitam */
    }

    .table thead {

        color: #fff;
    }

    .img-bukti {
        width: 80px;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
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
        /* Teks isi tabel warna hitam */
    }

    .text-muted {
        color: #6c757d !important;
    }

</style>

<div class="container-fluid">
    <h4 class="mb-4">Daftar Pembayaran Kambing</h4>

    {{-- Tombol Tambah Pembayaran --}}
    <div class="mb-3">
        <a href="{{ route('admin.pembayaran.tambah') }}" class="btn btn-primary align-items-center gap-1">
            <i class="mdi mdi-credit-card-plus-outline"></i> Tambah Pembayaran
        </a>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>Tanggal Pesan</th>
                    <th>Metode Bayar</th>
                    <th>Bukti Bayar</th>
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
                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pesan)->format('d M Y') }}</td>
                    <td>{{ ucfirst($pembayaran->metode_bayar) }}</td>
                    <td>
                        @if ($pembayaran->bukti_bayar)
                        <a href="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" target="_blank">
                            <img src="{{ asset('storage/' . $pembayaran->bukti_bayar) }}" class="img-bukti" alt="Bukti Bayar">
                        </a>
                        @else
                        <span class="text-muted">Belum Diupload</span>
                        @endif
                    </td>
                    <td>
                        @if ($pembayaran->status == 'selesai')
                        <span class="badge badge-success">Selesai</span>
                        @elseif ($pembayaran->status == 'menunggu')
                        <span class="badge badge-warning">Menunggu</span>
                        @else
                        <span class="badge badge-danger">Gagal</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($pembayaran->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.pembayaran.show', $pembayaran->id) }}" class="btn btn-sm btn-info">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada data pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
