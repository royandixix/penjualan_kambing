@extends('user.layout.app')

@section('title', 'Beli Kambing')

@section('content')
    <!-- Hero Section -->
    <div class="py-5 text-white" style="background: linear-gradient(135deg, #198754, #28a745); border-radius: 0 0 20px 20px;">
        <div class="container">
            <h1 class="fw-bold mb-1">Beli Kambing Berkualitas</h1>
            <p class="lead mb-0">Pilih kambing sehat, harga bersahabat, dan siap kirim ke rumah Anda!</p>
        </div>
    </div>

    <!-- Content -->
    <div class="container py-5">
        <h2 class="mb-4 fs-5 fw-semibold text-success border-start border-4 border-success ps-3">
            Temukan Kambing Terbaik Siap Jual di Bawah Ini:
        </h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($kambings as $kambing)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                        <!-- Badge -->
                        <span class="badge bg-success position-absolute top-0 start-0 m-2">Ready Stock</span>

                        <!-- Gambar -->
                        <img src="{{ asset('storage/' . $kambing->foto) }}" 
                             class="card-img-top" 
                             alt="Foto Kambing"
                             style="height: 220px; object-fit: cover; transition: transform 0.3s;"
                             onmouseover="this.style.transform='scale(1.03)'"
                             onmouseout="this.style.transform='scale(1)'">

                        <!-- Info -->
                        <div class="card-body">
                            <h5 class="card-title fw-bold text-success">{{ $kambing->nama }}</h5>
                            <ul class="list-unstyled mb-3 text-muted small">
                                <li><i class="bi bi-calendar3 me-2"></i> Umur: {{ $kambing->umur }} bulan</li>
                                <li><i class="bi bi-bar-chart-fill me-2"></i> Berat: {{ $kambing->berat }} kg</li>
                            </ul>
                            <p class="fw-bold fs-5 text-success mb-0">
                                Rp {{ number_format($kambing->harga, 0, ',', '.') }}
                            </p>
                        </div>

                        <!-- Aksi -->
                        <div class="card-footer bg-white border-0 d-flex justify-content-between px-3 pb-3">
                            <a href="{{ route('user.beli', $kambing->id) }}"
                               class="btn btn-success btn-sm px-3 shadow-sm d-flex align-items-center">
                                <i class="bi bi-bag-check-fill me-2"></i> Beli
                            </a>
                            <form action="{{ route('user.keranjang.tambah', $kambing->id) }}" method="POST"
                                  class="formKeranjang">
                                @csrf
                                <button type="submit"
                                        class="btn btn-outline-success btn-sm px-3 shadow-sm d-flex align-items-center tambah-keranjang"
                                        data-foto="{{ asset('storage/' . $kambing->foto) }}">
                                    <i class="bi bi-cart-plus-fill me-2"></i> Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const keranjangBtnList = document.querySelectorAll('.tambah-keranjang');

        keranjangBtnList.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const fotoUrl = btn.dataset.foto;
                const ikonKeranjang = document.getElementById('ikonKeranjang');

                // Buat gambar mini
                const img = document.createElement('img');
                img.src = fotoUrl;
                img.style.position = 'absolute';
                img.style.width = '80px';
                img.style.zIndex = '9999';
                img.style.borderRadius = '8px';
                img.style.transition = 'all 1s ease-in-out';

                // Posisi awal (tombol)
                const rectBtn = btn.getBoundingClientRect();
                img.style.left = rectBtn.left + 'px';
                img.style.top = rectBtn.top + 'px';
                document.body.appendChild(img);

                // Posisi akhir (ikon keranjang)
                const rectTarget = ikonKeranjang.getBoundingClientRect();
                setTimeout(() => {
                    img.style.left = rectTarget.left + 'px';
                    img.style.top = rectTarget.top + 'px';
                    img.style.opacity = 0;
                    img.style.transform = 'scale(0.2)';
                }, 10);

                // Hapus gambar setelah animasi
                setTimeout(() => {
                    img.remove();
                }, 1000);
            });
        });
    });
</script>
@endpush
