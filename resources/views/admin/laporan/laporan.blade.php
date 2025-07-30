@extends('admin.layouts.app')

@section('title', 'Laporan Pemesanan')

@section('content')
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        min-width: 1000px;
    }

    #toast-container {
        bottom: 50px !important;
        top: auto !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }

    .img-bukti {
        width: 100px;
        height: 100px;
        border-radius: 4px;
        object-fit: cover;
        margin: 4px;
    }

    .gambar-wrapper {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }
</style>

<div class="container-fluid">
    <h4 class="mb-4">Laporan Pemesanan</h4>

    <!-- Tombol Cetak PDF -->
    <div class="mb-3">
        <a href="{{ route('admin.laporan.cetak') }}" target="_blank" class="btn btn-primary">
            <i class="mdi mdi-printer"></i> Cetak PDF
        </a>
    </div>

    <!-- Tabel Laporan Pesanan -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal Pesan</th>
                    <th>Foto Kambing</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Metode Bayar</th>
                    <th>Bukti Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pesanans as $index => $pesanan)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center">{{ $pesanan->user->name ?? '-' }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d-m-Y') }}</td>
                        <td class="text-start">
                            <div class="gambar-wrapper">
                                @forelse ($pesanan->detailPesanans as $detail)
                                    @if ($detail->kambing && $detail->kambing->foto)
                                        <img src="{{ asset('storage/' . $detail->kambing->foto) }}" alt="Kambing" class="img-bukti">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="text-center">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                        <td class="text-center">{{ ucfirst($pesanan->status) }}</td>
                        <td class="text-center">{{ $pesanan->metode_bayar ?? '-' }}</td>
                        <td class="text-center">
                            @if ($pesanan->bukti_bayar)
                                <img src="{{ asset('storage/' . $pesanan->bukti_bayar) }}" alt="Bukti Bayar" class="img-bukti">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data pesanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-bottom-center",
        timeOut: "3000"
    };

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @elseif (session('error'))
        toastr.error("{{ session('error') }}");
    @elseif (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @elseif (session('info'))
        toastr.info("{{ session('info') }}");
    @endif
</script>
@endsection
