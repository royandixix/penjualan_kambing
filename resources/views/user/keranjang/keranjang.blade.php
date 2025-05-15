@extends('user.layout.app')

@section('title', 'Keranjang Pembelian')

@section('content')

<!-- BAGIAN HEADER DENGAN BACKGROUND GRADIENT -->
<div class="py-5 text-white" style="background: linear-gradient(135deg, #198754, #28a745); border-radius: 0 0 20px 20px;">
    <div class="container">
        <h1 class="fw-bold mb-1">Keranjang Pembelian</h1>
        <p class="lead mb-0">Lihat kembali produk yang ingin kamu beli sebelum checkout.</p>
    </div>
</div>

<!-- ISI KONTEN KERANJANG -->
<div class="py-5" style="background-color: #f8f9fa; min-height: 100vh;">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('keranjang') && count(session('keranjang')) > 0)
            <form action="{{ route('user.checkout') }}" method="POST">
                @csrf
                @php $total = 0; @endphp

                @foreach(session('keranjang') as $id => $item)
                    <div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <!-- Badge -->
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">Ready</span>

                        <div class="row g-0 align-items-center" style="background-color: #ffffff;">
                            <div class="col-1 text-center pt-3 ps-2">
                                <input type="checkbox" class="form-check-input item-checkbox" name="items[]" value="{{ $id }}" data-harga="{{ $item['harga'] }}">
                            </div>
                            <div class="col-3">
                                <img src="{{ asset('storage/' . $item['foto']) }}"
                                     class="img-fluid rounded-start shadow-sm"
                                     alt="foto"
                                     style="object-fit: cover; height: 100px; transition: transform 0.3s;"
                                     onmouseover="this.style.transform='scale(1.03)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            </div>
                            <div class="col-6">
                                <div class="card-body py-3">
                                    <h6 class="card-title mb-1 fw-semibold text-success">{{ $item['nama'] }}</h6>
                                    <p class="mb-1 text-muted">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                    <small class="text-secondary">Jumlah: 1</small>
                                </div>
                            </div>
                            <div class="col-3 text-end pe-4">
                                <form action="{{ route('user.keranjang.hapus', $id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Total dan Checkout -->
                <div class="card border-0 rounded-4 shadow-sm mt-4">
                    <div class="card-body d-flex justify-content-between align-items-center" style="background-color: #ffffff;">
                        <div>
                            <h6 class="mb-1">Total Belanja:</h6>
                            <h5 class="text-success fw-bold" id="totalHarga">Rp 0</h5>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg rounded-pill px-4" id="btnCheckout" disabled>
                            Checkout <i class="bi bi-cart-check ms-1"></i>
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center py-5">
                <img src="{{ asset('images/empty_cart.svg') }}" alt="Keranjang Kosong" class="mb-3" style="max-width: 200px;">
                <h5 class="fw-bold text-muted">Keranjang masih kosong</h5>
                <a href="{{ route('user.beli') }}" class="btn btn-outline-success mt-2">Belanja Sekarang</a>
            </div>
        @endif
    </div>
</div>

{{-- Script total dinamis --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const totalHarga = document.getElementById('totalHarga');
        const btnCheckout = document.getElementById('btnCheckout');

        function updateTotal() {
            let total = 0;
            let anyChecked = false;
            checkboxes.forEach(cb => {
                if (cb.checked) {
                    total += parseInt(cb.dataset.harga);
                    anyChecked = true;
                }
            });
            totalHarga.textContent = "Rp " + total.toLocaleString('id-ID');
            btnCheckout.disabled = !anyChecked;
        }

        checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
    });
</script>
@endsection
