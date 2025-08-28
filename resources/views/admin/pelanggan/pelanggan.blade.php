@extends('admin.layouts.app')

@section('title', 'Daftar Pelanggan')

@section('content')
<style>
    .table thead th {
        background-color: #f8f9fa;
        vertical-align: middle;
        text-align: center;
    }

    .table tbody td {
        vertical-align: middle;
        text-align: center;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
        transition: 0.2s ease-in-out;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.4em 0.6em;
        border-radius: 0.375rem;
    }

    .btn-action {
        transition: all 0.3s ease;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: white;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }

    #toast-container {
        bottom: 50px !important;
        top: auto !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
</style>

<div class="container-fluid">
    <h4 class="mb-4">Daftar Pelanggan</h4>

    <div class="mb-3">
        <a href="{{ route('admin.pelanggan.tambah') }}" class="btn btn-primary align-items-center gap-1">
            <i class="mdi mdi-account-plus-outline"></i> Tambah Pelanggan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-light text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pelanggan as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->no_hp }}</td>
                    <td>{{ $user->alamat }}</td>
                    <td>
                        <div class="d-flex flex-column gap-1">
                            <a href="{{ route('admin.pelanggan.edit', $user->id) }}" class="btn btn-sm btn-outline-warning btn-action d-flex justify-content-center align-items-center gap-1">
                                <i class="mdi mdi-pencil-outline"></i> Edit
                            </a>
                            <form action="{{ route('admin.pelanggan.destroy', $user->id) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger btn-action d-flex justify-content-center align-items-center gap-1 btn-delete">
                                    <i class="mdi mdi-delete-outline"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data pelanggan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-center",
        "timeOut": "3000"
    };

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @elseif(session('error'))
        toastr.error("{{ session('error') }}");
    @elseif(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @elseif(session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    document.addEventListener("DOMContentLoaded", function () {
        $('.btn-delete').on('click', function (e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Pelanggan ini akan dihapus permanen!",
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
