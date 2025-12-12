@extends('user.layout.app')

@section('title', 'Keranjang Pembelian')

@section('content')
<main>
    <!-- HEADER -->
    <div class="py-5 text-white" style="background: linear-gradient(135deg, #198754, #28a745); border-radius: 0 0 20px 20px;">
        <div class="container">
            <h1 class="fw-bold mb-1">Keranjang Pembelian</h1>
            <p class="lead mb-0">Lihat kembali produk yang ingin kamu beli sebelum checkout.</p>
        </div>
    </div>

    <!-- ISI KONTEN -->
    <div>
        <div class="container">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('keranjang') && count(session('keranjang')) > 0)
            @php $total = 0; @endphp

            @foreach(session('keranjang') as $id => $item)
            <div class="card mb-4 shadow-sm border-0 rounded-4 overflow-hidden position-relative">
                <span class="badge bg-success position-absolute top-0 start-0 m-2">Ready</span>
                <div class="row g-0 align-items-center bg-white">
                    <div class="col-1 text-center pt-3 ps-2">
                        <input type="checkbox" class="form-check-input item-checkbox" name="items[]" value="{{ $id }}" data-harga="{{ $item['harga'] }}">
                    </div>
                    <div class="col-3 img-3d-container" style="perspective: 1000px;">
                        <img src="{{ asset('storage/' . $item['foto']) }}" class="img-fluid rounded-start shadow-sm img-3d" alt="foto" style="object-fit: cover; height: 100px; transition: transform 0.1s ease; transform-style: preserve-3d;">
                    </div>
                    <div class="col-4">
                        <div class="card-body py-3">
                            <h6 class="fw-semibold text-success mb-1">{{ $item['nama'] }}</h6>
                            <p class="mb-1 text-muted">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                            <p class="mb-1 text-secondary">
                                Jenis: {{ $item['jenis_kambing'] }} | Berat: {{ $item['berat'] }} kg | Umur: {{ $item['umur'] }} bulan
                            </p>
                            <small class="text-secondary">Alamat: {{ $item['alamat'] }}</small>
                        </div>
                    </div>
                    <div class="col-4 text-center">
                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary minus-btn" data-id="{{ $id }}">−</button>
                            <input type="text" class="form-control text-center qty-input mx-1" value="{{ $item['jumlah'] ?? 1 }}" style="width: 50px;" data-id="{{ $id }}">
                            <button type="button" class="btn btn-sm btn-outline-success plus-btn" data-id="{{ $id }}">+</button>
                        </div>
                        <form action="{{ route('user.keranjang.hapus', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm w-100"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- TOTAL & BUTTON MODAL -->
            <div class="card border-0 rounded-4 shadow-sm mt-4">
                <div class="card-body bg-white d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Total Belanja:</h6>
                        <h5 class="text-success fw-bold" id="totalHarga">Rp 0</h5>
                    </div>
                    <button class="btn btn-success btn-lg rounded-pill px-4" id="openModal" disabled data-bs-toggle="modal" data-bs-target="#checkoutModal">
                        Checkout <i class="bi bi-cart-check ms-1"></i>
                    </button>
                </div>
            </div>

            <!-- MODAL -->
            <div class="modal fade" id="checkoutModal" tabindex="-1">
                <div class="modal-dialog">
                    <form class="modal-content" action="{{ route('user.checkout') }}" method="POST" enctype="multipart/form-data" id="formCheckout">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Pilih Metode Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <select class="form-select mb-3" name="metode_bayar" id="metodeBayarSelect" required>
                                <option value="" disabled selected>-- Pilih Metode --</option>
                                <option value="qris">QRIS (Scan QR)</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cod">Bayar di Tempat (COD)</option>
                            </select>

                            <div id="infoMetode" class="mb-3" style="display: none;"></div>

                            <div class="mb-3" id="uploadBukti" style="display: none;">
                                <label>Upload Bukti Pembayaran</label>
                                <input type="file" name="bukti_bayar" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Konfirmasi & Bayar</button>
                        </div>
                    </form>
                </div>
            </div>

            @else
            <div class="text-center py-5">
                <img src="{{ asset('images/empty_cart.svg') }}" alt="Keranjang Kosong" class="mb-3" style="max-width: 200px;">
                <h5 class="fw-bold text-muted">Keranjang masih kosong</h5>
                <a href="{{ route('user.kambing') }}" class="btn btn-outline-success mt-2">Belanja Sekarang</a>
            </div>
            @endif
        </div>
    </div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const totalHarga = document.getElementById('totalHarga');
    const btnOpenModal = document.getElementById('openModal');
    const formCheckout = document.getElementById('formCheckout');
    const metodeSelect = document.getElementById('metodeBayarSelect');
    const infoMetode = document.getElementById('infoMetode');
    const uploadBukti = document.getElementById('uploadBukti');

    function updateTotal() {
        let total = 0;
        let anyChecked = false;
        document.querySelectorAll('.dynamic-item-input').forEach(e => e.remove());

        checkboxes.forEach(cb => {
            const id = cb.value;
            const qtyInput = document.querySelector(`.qty-input[data-id="${id}"]`);
            const qty = parseInt(qtyInput.value) || 1;
            const harga = parseInt(cb.dataset.harga);

            if (cb.checked) {
                total += harga * qty;
                anyChecked = true;

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'items[]';
                input.value = id;
                input.dataset.qty = qty;
                input.classList.add('dynamic-item-input');
                formCheckout.appendChild(input);
            }
        });

        totalHarga.textContent = "Rp " + total.toLocaleString('id-ID');
        btnOpenModal.disabled = !anyChecked;
    }

    checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));

    // Tombol plus
    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const input = document.querySelector(`.qty-input[data-id="${id}"]`);
            input.value = parseInt(input.value) + 1;
            updateTotal();
        });
    });

    // Tombol minus
    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const input = document.querySelector(`.qty-input[data-id="${id}"]`);
            let val = parseInt(input.value);
            if (val > 1) {
                input.value = val - 1;
                updateTotal();
            }
        });
    });

    metodeSelect.addEventListener('change', function () {
        const metode = this.value;
        let html = '';
        uploadBukti.style.display = 'none';

        if (metode === 'qris') {
            html = `
                <div class="text-center"> 
                    <p>Scan QR untuk bayar:</p>
                    <img src="/storage/qr/qrcode/qr_123.png" alt="QRIS" class="img-fluid rounded shadow-sm" style="max-width:200px;">
                    <p class="small text-muted">Kirim bukti ke admin setelah transfer.</p>
                </div>`;
            uploadBukti.style.display = 'block';
        } else if (metode === 'transfer') {
            html = `
                <div>
                    <p>Transfer ke rekening berikut:</p>
                    <ul class="small">
                        BRI - 170901004940508 a.n. Ternak Kamberu
                    </ul>`;
            uploadBukti.style.display = 'block';
        } else if (metode === 'cod') {
            html = `<p class="text-success">Bayar di tempat saat pesanan sampai.</p>`;
        }

        infoMetode.innerHTML = html;
        infoMetode.style.display = 'block';
    });

    formCheckout.addEventListener('submit', function (e) {
        if (!metodeSelect.value) {
            e.preventDefault();
            alert('Pilih metode pembayaran terlebih dahulu!');
        }

        if ((metodeSelect.value === 'qris' || metodeSelect.value === 'transfer') &&
            !formCheckout.querySelector('input[name="bukti_bayar"]').files.length) {
            e.preventDefault();
            alert('Upload bukti pembayaran wajib untuk metode ini!');
        }
    });

    updateTotal(); // hitung total awal

    // Efek 3D pada gambar
    document.querySelectorAll('.img-3d-container').forEach(container => {
        const img = container.querySelector('.img-3d');
        
        container.addEventListener('mousemove', (e) => {
            const rect = container.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            const rotateX = (y - centerY) / 5;
            const rotateY = (centerX - x) / 5;
            
            img.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05)`;
        });
        
        container.addEventListener('mouseleave', () => {
            img.style.transform = 'rotateX(0) rotateY(0) scale(1)';
        });
    });
});
</script>
@endpush
@endsection