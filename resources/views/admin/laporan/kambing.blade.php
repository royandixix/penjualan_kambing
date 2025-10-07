@extends('admin.layouts.app')

@section('title', 'Laporan Kambing')

@section('content')
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table {
        min-width: 1000px;
    }
    .img-kambing {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
    }
</style>

<div class="container-fluid">
    <h4 class="mb-4">Laporan Kambing</h4>

    <!-- Tombol Cetak PDF -->
    <div class="mb-3">
        <a href="{{ route('admin.laporan.kambing.cetak') }}" target="_blank" class="btn btn-success">
            <i class="mdi mdi-file-pdf-outline"></i> Cetak PDF
        </a>
    </div>

    <!-- Tabel Laporan -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Jenis Kambing</th>
                    <th>Umur (bln)</th>
                    <th>Berat (kg)</th>
                    <th>Jenis Kelamin</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kambings as $index => $kambing)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kambing->jenis_kambing }}</td>
                    <td>{{ $kambing->umur }}</td>
                    <td>{{ $kambing->berat }}</td>
                    <td>{{ $kambing->jenis_kelamin }}</td>
                    <td>Rp {{ number_format($kambing->harga, 0, ',', '.') }}</td>
                    <td>{{ $kambing->stok }}</td>
                    <td>
                        @if ($kambing->foto)
                            <img src="{{ asset('storage/' . $kambing->foto) }}" alt="{{ $kambing->jenis_kambing }}" class="img-kambing">
                        @else
                            <em>-</em>
                        @endif
                    </td>
                    <td class="text-start">{{ $kambing->deskripsi }}</td>
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
