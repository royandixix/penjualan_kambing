@extends('admin.layouts.app')

@section('title', 'Laporan Kambing')

@section('content')
<style>
    .img-kambing {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 6px;
    }
</style>

<div class="container-fluid">
    <h4 class="mb-4">Laporan Kambing</h4>

    {{-- CETAK SEMUA --}}
    <div class="mb-3">
        <a href="{{ route('admin.laporan.kambing.cetak') }}"
           target="_blank"
           class="btn btn-success">
            Cetak Semua
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Jenis</th>
                    <th>Umur</th>
                    <th>Berat</th>
                    <th>Kelamin</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Foto</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kambings as $i => $kambing)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $kambing->jenis_kambing }}</td>
                        <td>{{ $kambing->umur }}</td>
                        <td>{{ $kambing->berat }}</td>
                        <td>{{ $kambing->jenis_kelamin }}</td>
                        <td>Rp {{ number_format($kambing->harga, 0, ',', '.') }}</td>
                        <td>{{ $kambing->stok }}</td>
                        <td>
                            @if ($kambing->foto)
                                <img src="{{ asset('storage/' . $kambing->foto) }}" class="img-kambing">
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-start">{{ $kambing->deskripsi }}</td>
                        <td>
                            {{-- CETAK PER ITEM --}}
                            <a href="{{ route('admin.laporan.kambing.cetak.item', $kambing->id) }}"
                               target="_blank"
                               class="btn btn-sm btn-danger">
                                Cetak
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
