@extends('admin.layouts.app')

@section('title', 'Tambah Pembayaran')

@section('content')
<div class="container-fluid py-4">
    <h4 class="mb-4">Tambah Pembayaran Baru</h4>

    <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama Pembeli --}}
        <div class="mb-3">
            <label for="user_id" class="form-label">Nama Pembeli</label>
            <select class="form-control" id="user_id" name="user_id">
                <option value="">-- Pilih Pembeli --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} (ID: {{ $user->id }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tanggal Pesan --}}
        <div class="mb-3">
            <label for="tanggal_pesan" class="form-label">Tanggal Pesan</label>
            <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" value="{{ old('tanggal_pesan') }}">
            @error('tanggal_pesan')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Metode Bayar --}}
        <div class="mb-3">
            <label for="metode_bayar" class="form-label">Metode Bayar</label>
            <input type="text" class="form-control" id="metode_bayar" name="metode_bayar" placeholder="Contoh: Transfer" value="{{ old('metode_bayar') }}">
            @error('metode_bayar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="menunggu" {{ old('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="gagal" {{ old('status') == 'gagal' ? 'selected' : '' }}>Gagal</option>
            </select>
            @error('status')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Total Harga --}}
        <div class="mb-3">
            <label for="total_harga" class="form-label">Total Harga</label>
            <input type="number" class="form-control" id="total_harga" name="total_harga" placeholder="Contoh: 2500000" value="{{ old('total_harga') }}">
            @error('total_harga')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Bukti Bayar --}}
        <div class="mb-3">
            <label for="bukti_bayar" class="form-label">Upload Bukti Bayar</label>
            <input type="file" class="form-control" id="bukti_bayar" name="bukti_bayar" accept="image/*">
            @error('bukti_bayar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

            {{-- PPEMBUATAAN DATA  SENYAK MUNGKIN  --}}
        
        {{-- Tombol --}}
        <button type="submit" class="btn btn-success">Simpan Pembayaran</button>
        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
