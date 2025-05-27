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
                <span class="badge bg-success position-absolute top-0 start-0 m-2">Ready Stock</span>

                <img src="{{ asset('storage/' . $kambing->foto) }}" class="card-img-top" alt="Foto Kambing"
                    style="height: 220px; object-fit: cover; transition: transform 0.3s;"
                    onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">

                <div class="card-body">
                    <h5 class="card-title text-success">{{ $kambing->nama }}</h5>
                    <ul class="list-unstyled mb-3 text-muted small">
                        <li><i class="bi bi-calendar3 me-2"></i> Umur: {{ $kambing->umur }} bulan</li>
                        <li><i class="bi bi-bar-chart-fill me-2"></i> Berat: {{ $kambing->berat }} kg</li>
                    </ul>
                    <p class="fs-5 text-success mb-0">Rp {{ number_format($kambing->harga, 0, ',', '.') }}</p>
                </div>

                <div class="card-footer bg-white border-0 d-flex justify-content-between px-3 pb-3">
                    <form action="{{ route('user.keranjang.tambah', $kambing->id) }}" method="POST" class="formKeranjang">
                        @csrf
                        <button type="submit"
                            class="btn btn-outline-success btn-sm px-3 shadow-sm d-flex align-items-center tambah-keranjang"
                            data-foto="{{ asset('storage/' . $kambing->foto) }}">
                            <i class="bi bi-cart-plus-fill me-2"></i> Keranjang
                        </button>
                    </form>

                    <button type="button" class="btn btn-success btn-sm px-3 shadow-sm d-flex align-items-center"
                        data-bs-toggle="modal" data-bs-target="#modalMetodeBayar{{ $kambing->id }}">
                        <i class="bi bi-bag-check-fill me-2"></i> Beli
                    </button>
                </div>

                <!-- Modal Metode Pembayaran -->
                <div class="modal fade" id="modalMetodeBayar{{ $kambing->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 shadow">
                            <div class="modal-header bg-success text-white rounded-top">
                                <h5 class="modal-title">Pilih Metode Pembayaran</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formBayar{{ $kambing->id }}" action="{{ route('user.beli', $kambing->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <select class="form-select metode-select" name="metode_bayar" data-id="{{ $kambing->id }}" required>
                                            <option value="" disabled selected>-- Pilih Metode --</option>
                                            <option value="qris">QRIS (Scan QR)</option>
                                            <option value="transfer">Transfer Bank</option>
                                            <option value="cod">Bayar di Tempat (COD)</option>
                                        </select>
                                    </div>

                                    <div class="info-metode mb-3" id="infoMetode{{ $kambing->id }}" style="display: none;"></div>

                                    <div class="mb-3" id="uploadBukti{{ $kambing->id }}" style="display: none;">
                                        <label class="form-label">Upload Bukti Pembayaran</label>
                                        <input type="file" class="form-control" name="bukti_bayar" accept="image/*">
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success">
                                            Lanjutkan <i class="bi bi-arrow-right-circle ms-2"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
    // Animasi Keranjang
    document.querySelectorAll('.tambah-keranjang').forEach(btn => {
        btn.addEventListener('click', () => {
            const fotoUrl = btn.dataset.foto;
            const ikonKeranjang = document.getElementById('ikonKeranjang');
            const img = document.createElement('img');

            img.src = fotoUrl;
            img.style.position = 'absolute';
            img.style.width = '80px';
            img.style.zIndex = '9999';
            img.style.borderRadius = '8px';
            img.style.transition = 'all 1s ease-in-out';

            const rectBtn = btn.getBoundingClientRect();
            img.style.left = rectBtn.left + 'px';
            img.style.top = rectBtn.top + 'px';
            document.body.appendChild(img);

            const rectTarget = ikonKeranjang.getBoundingClientRect();
            setTimeout(() => {
                img.style.left = rectTarget.left + 'px';
                img.style.top = rectTarget.top + 'px';
                img.style.opacity = 0;
                img.style.transform = 'scale(0.2)';
            }, 10);

            setTimeout(() => img.remove(), 1000);
        });
    });

    // Toggle Upload dan Info Metode
    document.querySelectorAll('.metode-select').forEach(select => {
        select.addEventListener('change', function () {
            const metode = this.value;
            const id = this.dataset.id;
            const infoContainer = document.getElementById('infoMetode' + id);
            const uploadInput = document.getElementById('uploadBukti' + id);

            let html = '';
            if (metode === 'qris') {
                html = `
                    <div class="text-center">
                        <p class="mb-2">Scan QRIS untuk pembayaran:</p>
                        <img src="/storage/qrcode/qr_123.png" alt="QRIS Dinamis" style="max-width: 250px;" class="img-fluid rounded shadow-sm">
                        <p class="mt-2 text-muted small">Setelah transfer, kirim bukti ke admin via WhatsApp.</p>
                 </div>`;
                uploadInput.style.display = 'block';
            } else if (metode === 'transfer') {
                html = `
                    <div>
                        <p>Silakan transfer ke salah satu rekening di bawah ini:</p>
                        <ul class="small">
                            <li><strong>BCA</strong> - 1234567890 a.n. PT Kambing Sejahtera</li>
                            <li><strong>Mandiri</strong> - 9876543210 a.n. PT Kambing Sejahtera</li>
                        </ul>
                        <p class="text-muted small">Konfirmasi transfer ke admin setelah pembayaran.</p>
                    </div>`;
                uploadInput.style.display = 'block';
            } else if (metode === 'cod') {
                html = `<p class="text-success">Pembayaran dilakukan saat kambing sampai ke rumah Anda.</p>`;
                uploadInput.style.display = 'none';
            }

            infoContainer.innerHTML = html;
            infoContainer.style.display = 'block';
        });
    });

    // Validasi Form Submit
    document.querySelectorAll('form[id^="formBayar"]').forEach(form => {
        form.addEventListener('submit', function (e) {
            const select = form.querySelector('select[name="metode_bayar"]');
            const metode = select.value;

            if (!metode) {
                e.preventDefault();
                alert('Silakan pilih metode pembayaran terlebih dahulu!');
                return;
            }

            if ((metode === 'qris' || metode === 'transfer') && !form.querySelector('input[name="bukti_bayar"]').files.length) {
                e.preventDefault();
                alert('Silakan upload bukti pembayaran terlebih dahulu!');
            }
        })
    });
});
</script>
@endpush
