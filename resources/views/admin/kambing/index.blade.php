@extends('admin.layouts.app')

@section('title', 'Daftar Kambing')

@section('content')
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        min-width: 1200px;
    }

    /* Tombol aksi */
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #fff;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-outline-warning,
    .btn-outline-danger {
        transition: all 0.3s ease;
    }

    /* Gambar tabel */
    .img-kambing {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }

</style>

<div class="container-fluid">
    <h4 class="mb-4">Daftar Kambing</h4>

    <!-- Tombol Tambah Data -->
    <div class="mb-3">
        <a href="{{ route('admin.kambing.tambah') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah Data
        </a>
    </div>

    <!-- <a href="{{ route('admin.kambing.exportPdf') }}" target="_blank" class="btn btn-success mb-3">
        <i class="mdi mdi-file-pdf-outline"></i> Export PDF
    </a>
     -->

    <!-- Tabel Data Kambing -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Jenis Kambing</th>
                    <th>Umur</th>
                    <th>Berat</th>
                    <th>Jenis Kelamin</th>
                    <th>Harga</th>
                    <th>stock</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                    <th class="text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kambings as $index => $kambing)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kambing->jenis_kambing}}</td>
                    <td>{{ $kambing->umur }} bln</td>
                    <td>{{ $kambing->berat }} kg</td>
                    <td>{{ $kambing->jenis_kelamin }}</td>
                    <td>Rp {{ number_format($kambing->harga, 0, ',', '.') }}</td>
                    <td>{{ $kambing->stok }}</td> <!-- Tambahkan stok -->
                    <td>
                        @if ($kambing->foto)
                        <img src="{{ asset('storage/' . $kambing->foto) }}" alt="{{ $kambing->jenis_kambing }}" class="img-kambing">
                        @else
                        <em>Belum ada foto</em>
                        @endif
                    </td>
                    <td class="text-start">{{ $kambing->deskripsi }}</td>
                    <td>
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.kambing.edit', $kambing->id) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center justify-content-center gap-1">
                                <i class="mdi mdi-pencil-outline"></i> Edit
                            </a>
                            <form action="{{ route('admin.kambing.destroy', $kambing->id) }}" method="POST" class="d-inline form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center gap-1 btn-delete">
                                    <i class="mdi mdi-delete-outline"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                
                @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data kambing.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<!-- Load SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('.btn-delete').on('click', function (e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Data kambing akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
