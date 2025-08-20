@extends('user.layout.app')

@section('title', 'Riwayat Pembelian')

@section('content')
<main>
    <!-- HEADER -->
    <div class="py-5 text-white" style="background: linear-gradient(135deg, #198754, #28a745); border-radius: 0 0 20px 20px;">
        <div class="container">
            <h1 class="fw-bold mb-1">Riwayat Pembelian</h1>
            <p class="lead mb-0">Lihat transaksi yang telah kamu lakukan.</p>
        </div>
    </div>

    <div class="container my-4">
        @if($riwayat->isEmpty())
            <div class="text-center py-5">
                <img src="{{ asset('images/empty_cart.svg') }}" alt="Kosong" class="mb-3" style="max-width: 200px;">
                <h5 class="fw-bold text-muted">Belum ada riwayat pembelian</h5>
                <a href="{{ route('user.kambing') }}" class="btn btn-outline-success mt-2">Belanja Sekarang</a>
            </div>
        @else
            @foreach($riwayat as $pesanan)
                <div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                    <span class="badge bg-success position-absolute top-0 start-0 m-2">
                        {{ ucfirst($pesanan->status) }}
                    </span>
                    <div class="card-body bg-white">
                        <h5 class="mb-3">Pesanan pada {{ $pesanan->created_at->format('d M Y') }}</h5>
                        
                        @foreach($pesanan->kambings as $kambing)
                            <div class="row g-0 align-items-center mb-3">
                                <div class="col-3">
                                    <img src="{{ asset('storage/' . $kambing->foto) }}" class="img-fluid rounded shadow-sm" alt="foto" style="object-fit: cover; height: 80px;">
                                </div>
                                <div class="col-6 ps-3">
                                    <h6 class="fw-semibold text-success mb-1">{{ $kambing->nama }}</h6>
                                    <p class="mb-1 text-muted">Rp {{ number_format($kambing->pivot->harga_satuan ?? 0, 0, ',', '.') }}</p>
                                    <small class="text-secondary">Jumlah: {{ $kambing->pivot->jumlah ?? 1 }}</small>
                                </div>
                                <div class="col-3 text-end">
                                    <span class="fw-bold">Subtotal</span><br>
                                    <span class="text-success">Rp {{ number_format($kambing->pivot->subtotal ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        @endforeach

                        <div class="border-top pt-2 mt-3 text-end">
                            <strong>Total: {{ $pesanan->total_harga_formatted }}</strong>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</main>
@endsection
