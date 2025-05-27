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

    #toast-container {
        bottom: 50px !important;
        top: auto !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
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

    <!-- Tabel Data Kambing -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>Berat</th>
                    <th>Jenis Kelamin</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th class="">Deskripsi</th>
                    <th class="text-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kambings as $index => $kambing)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kambing->nama }}</td>
                        <td>{{ $kambing->umur }} bln</td>
                        <td>{{ $kambing->berat }} kg</td>
                        <td>{{ $kambing->jenis_kelamin }}</td>
                        <td>Rp {{ number_format($kambing->harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($kambing->foto)
                                <img src="{{ asset('storage/' . $kambing->foto) }}" alt="{{ $kambing->nama }}" class="img-kambing">
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
                                <form action="{{ route('admin.kambing.destroy', $kambing->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center justify-content-center gap-1">
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

@section('scripts')
    <!-- jQuery & Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: "toast-bottom-center",
            timeOut: "3000"
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
