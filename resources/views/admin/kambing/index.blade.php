@extends('admin.layouts.app')

@section('title', 'Daftar Kambing')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Daftar Kambing</h4>

    <!-- Tombol Tambah Data -->
    <div class="mb-3">
        <a href="{{ route('admin.kambing.tambah') }}" class="btn btn-primary">
            <i class="mdi mdi-plus"></i> Tambah Data
        </a>
    </div>

    <!-- Tabel Data Kambing -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Umur</th>
                <th>Berat</th>
                <th>Jenis Kelamin</th>
                <th>Harga</th>
                <th>Foto</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kambings as $kambing)
                <tr>
                    <td>{{ $kambing->nama }}</td>
                    <td>{{ $kambing->umur }} bulan</td>
                    <td>{{ $kambing->berat }} kg</td>
                    <td>{{ $kambing->jenis_kelamin }}</td>
                    <td>Rp {{ number_format($kambing->harga, 0, ',', '.') }}</td>
                    <td>
                        @if ($kambing->foto)
                            <img src="{{ asset('storage/' . $kambing->foto) }}" alt="{{ $kambing->nama }}" width="80">
                        @else
                            <em>Belum ada foto</em>
                        @endif
                    </td>
                    <td>{{ $kambing->deskripsi }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data kambing.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
