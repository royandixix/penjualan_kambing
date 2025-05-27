@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<style>
    .img-bukti {
        border-radius: 0.75rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        max-width: 200px;
        height: auto;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;
    }

    .img-bukti:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .badge-status {
        padding: 0.5em 0.8em;
        font-size: 0.85rem;
        border-radius: 0.5rem;
    }

    .table th, .table td {
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .table th {
        background-color: #f1f5f9;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9fafb;
    }

    .card.fade-in {
        animation: fadeInUp 0.5s ease-out;
        opacity: 0;
        transform: translateY(10px);
        animation-fill-mode: forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Modal Styling */
    #imageModal {
        display: none;
        position: fixed;
        z-index: 1055;
        background-color: rgba(0, 0, 0, 0.85);
        width: 100vw;
        height: 100vh;
        top: 0;
        left: 0;
        justify-content: center;
        align-items: center;
    }

    #imageModal.active {
        display: flex;
    }

    #imageModal img {
        max-height: 90vh;
        max-width: 90vw;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
    }

    #imageModal span {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 2rem;
        color: #fff;
        cursor: pointer;
        z-index: 1060;
    }
</style>

<div class="container-fluid">
    <div class="card shadow-lg mb-5 fade-in">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"> Detail Pesanan</h5>
        </div>

        <div class="card-body">
            <!-- Info Pemesan -->
            <div class="mb-4">
                <h6 class="text-muted">🧑 Informasi Pemesan</h6>
                <ul class="list-unstyled">
                    <li><strong>Nama:</strong> {{ $pesanan->user->name ?? 'Tidak ditemukan' }}</li>
                    <li><strong>Email:</strong> {{ $pesanan->user->email ?? '-' }}</li>
                    <li><strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y') }}</li>
                    <li><strong>Status:</strong>
                        <span class="badge badge-status {{ $pesanan->status == 'pending' ? 'bg-warning text-dark' : 'bg-success' }}">
                            {{ ucfirst($pesanan->status) }}
                        </span>
                    </li>
                    <li><strong>Total Harga:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</li>
                </ul>
            </div>

            <!-- Rincian Kambing -->
            <div class="mb-4">
                <h6 class="text-muted">🐐 Rincian Kambing</h6>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Kambing</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pesanan->detailPesanans as $index => $detail)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $detail->kambing->nama ?? 'Data tidak ditemukan' }}</td>
                                    <td class="text-center">{{ $detail->jumlah }}</td>
                                    <td>Rp {{ number_format($detail->kambing->harga ?? 0, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada rincian pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bukti Pembayaran -->
            @if ($pesanan->bukti_bayar)
            <div class="text-center mb-4">
                <h6 class="text-muted">🧾 Bukti Pembayaran</h6>
                <img src="{{ asset('storage/' . $pesanan->bukti_bayar) }}"
                     alt="Bukti Bayar"
                     class="img-bukti mb-2"
                     id="previewImage"
                     data-src="{{ asset('storage/' . $pesanan->bukti_bayar) }}">
                <br>
                <button class="btn btn-outline-primary btn-sm mt-2"
                        onclick="downloadImage('{{ asset('storage/' . $pesanan->bukti_bayar) }}')">
                    <i class="bi bi-download"></i> Download Gambar
                </button>
            </div>
            @endif

            <!-- Tombol Kembali -->
            <div class="text-end">
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

>

<!-- Modal Gambar -->
<div id="imageModal">
    <span onclick="closeModal()">&times;</span>
    <img id="modalImage" src="">
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Detail Pesanan Dimuat!',
            text: 'Berikut adalah rincian lengkap dari pesanan.',
            icon: 'info',
            confirmButtonText: 'Oke 👍',
            confirmButtonColor: '#3085d6'
        });

        const modal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const previewImage = document.getElementById('previewImage');

        previewImage?.addEventListener('click', function () {
            modalImage.src = this.dataset.src;
            modal.classList.add('active');
        });

        window.closeModal = () => {
            modal.classList.remove('active');
            modalImage.src = '';
        };

        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });
    });

    function downloadImage(url) {
        const link = document.createElement('a');
        link.href = url;
        link.download = 'bukti-pembayaran.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endpush
