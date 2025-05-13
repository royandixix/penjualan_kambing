@extends('admin.layouts.app')

@section('title', 'Daftar Pengguna')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Daftar Pengguna</h4>

        <!-- Tombol Tambah Pengguna -->
        <div class="mb-3">
            <a href="{{ route('admin.pengguna.tambah') }}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> Tambah Pengguna
            </a>
        </div>

        <!-- Tabel Data Pengguna -->
        <table class="table table-bordered">
            <thead>
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
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.pengguna.edit', $user->id) }}"
                                    class="btn btn-sm btn-warning mb-1">
                                    Edit
                                </a>
                                <form action="{{ route('admin.pengguna.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

<style>
    #toast-container {
        bottom: 50px !important;
        top: 100px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
</style>

@section('scripts')
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
