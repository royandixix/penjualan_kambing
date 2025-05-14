@extends('user.layout.app')

@section('title', 'Keranjang Pembelian')

@section('content')
<div class="container py-4">
    <h3 class="mb-3 fw-bold text-success">Keranjang Pembelian</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('keranjang') && count(session('keranjang')) > 0)
        @php
            $total = 0;
        @endphp

        @foreach(session('keranjang') as $id => $item)
            @php $total += $item['harga']; @endphp
            <div class="card mb-3 shadow-sm border-0 rounded-4">
                <div class="row g-0 align-items-center">
                    <div class="col-3">
                        <img src="{{ asset('storage/' . $item['foto']) }}" class="img-fluid rounded-start" style="object-fit: cover; height: 100px;" alt="foto">
                    </div>
                    <div class="col-6">
                        <div class="card-body py-2">
                            <h6 class="card-title mb-1 fw-semibold">{{ $item['nama'] }}</h6>
                            <p class="mb-1 text-muted">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                            <small class="text-secondary">Jumlah: 1</small>
                        </div>
                    </div>
                    <div class="col-3 text-end pe-3">
                        <form action="{{ route('user.keranjang.hapus', $id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Total dan Checkout -->
        <div class="card border-0 rounded-4 shadow-sm mt-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Total Belanja:</h6>
                    <h5 class="text-success fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                </div>
                <a href="{{ route('user.checkout') }}" class="btn btn-success btn-lg rounded-pill px-4">
                    Checkout <i class="bi bi-cart-check ms-1"></i>
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <img src="{{ asset('images/empty_cart.svg') }}" alt="Keranjang Kosong" class="mb-3" style="max-width: 200px;">
            <h5 class="fw-bold text-muted">Keranjang masih kosong</h5>
            <a href="{{ route('user.beli') }}" class="btn btn-outline-success mt-2">Belanja Sekarang</a>
        </div>
    @endif
</div>
@endsection
