@extends('admin.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Daftar Pesanan Masuk</h4>

        <!-- Tabel Data Pesanan -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="">
                    <tr>
                        <th>No</th>
                        <th>Nama Pembeli</th>
                        <th>Tanggal Pesan</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanans as $pesanan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pesanan->user->name ?? 'Nama tidak ditemukan' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y') }}</td>
                            <td>
                                <span class="badge {{ $pesanan->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" class="btn btn-sm btn-info btn-block mb-1">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Baris tambahan untuk detail pesanan -->
                        <tr>
                            <td colspan="6" class="bg-light">
                                <strong>Detail Kambing:</strong>
                                <ul class="mb-0">
                                    @foreach ($pesanan->detail_pesanans as $detail)
                                        <li>
                                            Nama: {{ $detail->kambing->nama ?? '-' }},
                                            Jumlah: {{ $detail->jumlah }},
                                            Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

<style>
    #toast-container {
        bottom: 50px !important;
        top: 100px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
</style>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-center",
            "timeOut": "3000"
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
