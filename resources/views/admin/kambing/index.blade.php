@extends('admin.layouts.app')

@section('title', 'Daftar Kambing')

@section('content')
    <div class="container">
        <h1>Daftar Kambing</h1>
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
                @foreach($kambings as $kambing)
                <tr>
                    <td>{{ $kambing->nama }}</td>
                    <td>{{ $kambing->umur }}</td>
                    <td>{{ $kambing->berat }}</td>
                    <td>{{ $kambing->jenis_kelamin }}</td>
                    <td>Rp {{ number_format($kambing->harga, 0, ',', '.') }}</td>
                    <td>
                        @if($kambing->foto)
                            <img src="{{ asset('storage/' . $kambing->foto) }}" alt="{{ $kambing->nama }}" width="80">
                        @else
                            <em>Tidak ada foto</em>
                        @endif
                    </td>
                    <td>{{ $kambing->deskripsi }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
