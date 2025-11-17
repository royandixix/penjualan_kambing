@extends('admin.layouts.app')

@section('title', 'Daftar Kambing')

@section('content')
<style>
    .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .table { min-width: 1200px; }
    .btn-outline-warning:hover { background-color: #ffc107; color: #fff; }
    .btn-outline-danger:hover { background-color: #dc3545; color: #fff; }
    .btn-outline-warning, .btn-outline-danger { transition: all 0.3s ease; }
    .img-kambing { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; }
</style>

<div class="container-fluid">
    <h4 class="mb-4">Daftar Kambing</h4>

    <div class="mb-3">
        <a href="{{ route('admin.kambing.create') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah Data
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Jenis Kambing</th>
                    <th>Kategori</th>
                    <th>Umur</th>
                    <th>Berat</th>
                    <th>Jenis Kelamin</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($kambings as $index => $kambing)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kambing->jenis_kambing }}</td>
                    <td>{{ $kambing->kategori }}</td>
                    <td>{{ $kambing->umur }} bln</td>
                    <td>{{ $kambing->berat }} kg</td>
                    <td>{{ $kambing->jenis_kelamin }}</td>
                    <td>Rp {{ number_format($kambing->harga,0,',','.') }}</td>
                    <td>{{ $kambing->stok }}</td>
                    <td>
                        @if($kambing->foto)
                            <img src="{{ asset('storage/' . $kambing->foto) }}" class="img-kambing">
                        @else
                            <em>Belum ada foto</em>
                        @endif
                    </td>
                    <td>{{ $kambing->deskripsi }}</td>
                    <td>
                        <a href="{{ route('admin.kambing.edit', $kambing->id) }}" class="btn btn-outline-warning btn-sm mb-1">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('admin.kambing.destroy', $kambing->id) }}" method="POST" class="d-inline btn-delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm mb-1">
                                <i class="mdi mdi-delete"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $kambings->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const deleteForms = document.querySelectorAll('.btn-delete-form');

    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e){
            e.preventDefault();
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
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush
