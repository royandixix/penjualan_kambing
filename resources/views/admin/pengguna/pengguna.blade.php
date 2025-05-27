@extends('admin.layouts.app')

@section('title', 'Daftar Pengguna')

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
    <h4 class="mb-4">Daftar Pengguna</h4>

    <!-- Tombol Tambah Pengguna -->
    <div class="mb-3">
        <a href="{{ route('admin.pengguna.tambah') }}" class="btn btn-primary align-items-center gap-1">
            <i class="mdi mdi-account-plus-outline"></i> Tambah Pengguna
        </a>
    </div>

    <!-- Tabel Data Pengguna -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm">
            <thead class="table-light text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_hp }}</td>
                        <td>{{ $user->alamat }}</td>
                        <td><span class="badge bg-info text-dark">{{ ucfirst($user->role) }}</span></td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <a href="{{ route('admin.pengguna.edit', $user->id) }}"
                                    class="btn btn-sm btn-outline-warning btn-action d-flex justify-content-center align-items-center gap-1">
                                    <i class="mdi mdi-pencil-outline"></i> Edit
                                </a>
                                <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-outline-danger btn-action d-flex justify-content-center align-items-center gap-1">
                                        <i class="mdi mdi-delete-outline"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada data pengguna.</td>
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
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-bottom-center",
            "timeOut": "3000"
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
