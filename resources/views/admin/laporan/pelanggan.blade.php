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
</style>

<div class="container-fluid">
    <h4 class="mb-4">Daftar Pelanggan</h4>

    {{-- CETAK SEMUA --}}
    <div class="mb-3">
        <a href="{{ route('admin.laporan.pelanggan.cetak') }}"
           target="_blank"
           class="btn btn-success">
            Export PDF
        </a>

        <a href="{{ route('admin.laporan.pelanggan.excel') }}"
           class="btn btn-primary">
            Export Excel
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
                    <th>Aksi</th> {{-- 🔥 PENTING --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($pelanggans as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->no_hp }}</td>
                    <td>{{ $user->alamat }}</td>
                    <td>
                        {{-- CETAK PER ITEM --}}
                        <a href="{{ route('admin.laporan.pelanggan.cetak.item', $user->id) }}"
                           target="_blank"
                           class="btn btn-sm btn-danger">
                            Cetak
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Belum ada data pelanggan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
