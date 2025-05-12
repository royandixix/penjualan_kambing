@extends('layouts.app') {{-- atau layout lain jika kamu pakai admin template --}}

@section('content')
<div class="container">
    <h3 class="mb-4">Data Kambing</h3>
    <table class="table mb-0 table-hover align-middle text-nowrap">
        <thead>
            <tr>
                <th class="border-top-0">Nama</th>
                <th class="border-top-0">Umur</th>
                <th class="border-top-0">Berat</th>
                <th class="border-top-0">Jenis Kelamin</th>
                <th class="border-top-0">Harga</th>
                <th class="border-top-0">Foto</th>
                <th class="border-top-0">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kambings as $kambing)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="m-r-10">
                            <a class="btn btn-circle d-flex btn-info text-white">
                                {{ strtoupper(substr($kambing->nama, 0, 2)) }}
                            </a>
                        </div>
                        <div class="">
                            <h4 class="m-b-0 font-16">{{ $kambing->nama }}</h4>
                        </div>
                    </div>
                </td>
                <td>{{ $kambing->umur }} bulan</td>
                <td>{{ $kambing->berat }} kg</td>
                <td>{{ $kambing->jenis_kelamin }}</td>
                <td><h5 class="m-b-0">Rp{{ number_format($kambing->harga, 0, ',', '.') }}</h5></td>
                <td>
                    @if($kambing->foto)
                        <img src="{{ asset('storage/' . $kambing->foto) }}" alt="foto kambing" width="60">
                    @else
                        <span class="text-muted">Tidak ada foto</span>
                    @endif
                </td>
                <td>{{ $kambing->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


