@extends('admin.layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4 fw-bold"><i class="bi bi-list-check"></i> Daftar Pesanan Masuk</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="text-center">
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
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $pesanan->user->name ?? 'Tidak ditemukan' }}</td>
                            <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y') }}</td>
                            <td class="text-center">
                                @php
                                    $badgeClass = match ($pesanan->status) {
                                        'pending' => 'bg-warning text-dark',
                                        'selesai' => 'bg-success',
                                        'ditolak' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                    $iconClass = match ($pesanan->status) {
                                        'pending' => 'bi-hourglass-split',
                                        'selesai' => 'bi-check-circle',
                                        'ditolak' => 'bi-x-circle',
                                        default => 'bi-question-circle',
                                    };
                                @endphp
                                <span class="badge rounded-pill {{ $badgeClass }}">
                                    <i class="bi {{ $iconClass }}"></i>
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td class="text-center d-flex justify-content-center gap-2 flex-wrap">
                                <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye-fill"></i> Detail
                                </a>

                                {{-- Tombol Terima --}}
                                <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-check-circle"></i> Terima
                                    </button>
                                </form>

                                {{-- Tombol Tolak --}}
                                <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="ditolak">
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-x-circle"></i> Tolak
                                    </button>
                                </form>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.pesanan.destroy', $pesanan->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" class="bg-light small">
                                <strong class="text-primary">📝 Rincian Jenis Kambing:</strong>
                                <ul class="mb-0 ps-3">
                                    @forelse ($pesanan->detailPesanans as $detail)
                                    <li>
                                        <span class="fw-semibold">{{ $detail->kambing->jenis ?? '-' }}</span>
                                        - Jumlah: <strong>{{ $detail->jumlah }}</strong>,
                                        Subtotal: <strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                                    </li>
                                    @empty
                                    <li class="text-muted fst-italic">Tidak ada rincian.</li>
                                    @endforelse

                                    @if ($pesanan->bukti_bayar && file_exists(storage_path('app/public/bukti_bayar/' . $pesanan->bukti_bayar)))
                                    <li>
                                        <strong>Bukti Bayar:</strong>
                                        <a href="{{ asset('storage/bukti_bayar/' . $pesanan->bukti_bayar) }}" target="_blank">Lihat Bukti</a>
                                    </li>
                                    @endif
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
                <div class="mt-3">
                    {{ $pesanans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-bottom-center",
        timeOut: "3000"
    };

    @if(session('success'))
        toastr.success("{{ session('success') }}", "Berhasil");
    @elseif(session('error'))
        toastr.error("{{ session('error') }}", "Gagal");
    @elseif(session('warning'))
        toastr.warning("{{ session('warning') }}", "Peringatan");
    @elseif(session('info'))
        toastr.info("{{ session('info') }}", "Info");
    @endif

    // Konfirmasi hapus
    $(document).on('click', 'form button.btn-outline-danger', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Pesanan akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Konfirmasi terima / tolak
    $(document).on('click', 'form button.btn-outline-success, form button.btn-outline-warning', function (e) {
        e.preventDefault();
        let form = $(this).closest('form');
        let actionText = $(this).hasClass('btn-outline-success') ? 'Menerima' : 'Menolak';

        Swal.fire({
            title: actionText + ' pesanan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endpush
