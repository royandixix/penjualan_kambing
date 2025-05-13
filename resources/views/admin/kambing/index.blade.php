@extends('admin.layouts.app')

@section('title', 'Daftar Kambing')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Daftar Kambing</h4>

        <!-- Tombol Tambah Data -->
        <div class="mb-3">
            <a href="{{ route('admin.kambing.create') }}" class="btn btn-primary">
                <i class="mdi mdi-plus"></i> Tambah Data
            </a>
        </div>

        <!-- Tabel Data Kambing -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>Berat</th>
                    <th>Jenis Kelamin</th>
                    <th>Harga</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kambings as $index => $kambing)
                    <tr>
                        <td>{{ $index + 1 }}</td>
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
                        <td>
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.kambing.edit', $kambing->id) }}"
                                    class="btn btn-sm btn-warning btn-block mb-1">
                                    Edit
                                </a>
                                <form action="{{ route('admin.kambing.destroy', $kambing->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-block">
                                        Hapus
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
@endsection
