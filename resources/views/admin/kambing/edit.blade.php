@extends('admin.layouts.app')

@section('title', 'Edit Kambing')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Edit Data Kambing</h4>

    {{-- Validasi Error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Ada kesalahan pada input:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kambing.update', $kambing->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Jenis Kambing --}}
        <div class="form-group mb-3">
            <label for="jenis_kambing">Jenis Kambing</label>
            <input type="text" name="jenis_kambing" class="form-control"
                   value="{{ old('jenis_kambing', $kambing->jenis_kambing) }}" required>
        </div>

        {{-- Kategori --}}
        <div class="form-group mb-3">
            <label for="kategori">Kategori</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="Kambing Kacang" {{ old('kategori', $kambing->kategori) == 'Kambing Kacang' ? 'selected' : '' }}>Kambing Kacang</option>
                <option value="Kambing Peranakan Etawa" {{ old('kategori', $kambing->kategori) == 'Kambing Peranakan Etawa' ? 'selected' : '' }}>Kambing Peranakan Etawa</option>
            </select>
        </div>

        {{-- Umur --}}
        <div class="form-group mb-3">
            <label for="umur">Umur (bulan)</label>
            <input type="number" name="umur" class="form-control" value="{{ old('umur', $kambing->umur) }}" required>
        </div>

        {{-- Berat --}}
        <div class="form-group mb-3">
            <label for="berat">Berat (kg)</label>
            <input type="text" name="berat" id="berat" class="form-control" value="{{ old('berat', $kambing->berat) }}" required>
        </div>

        {{-- Jenis Kelamin --}}
        <div class="form-group mb-3">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Jantan" {{ strtolower(old('jenis_kelamin', $kambing->jenis_kelamin)) == 'jantan' ? 'selected' : '' }}>Jantan</option>
                <option value="Betina" {{ strtolower(old('jenis_kelamin', $kambing->jenis_kelamin)) == 'betina' ? 'selected' : '' }}>Betina</option>
            </select>
        </div>

        {{-- Harga --}}
        <div class="form-group mb-3">
            <label for="harga">Harga (Rp)</label>
            <input type="text" name="harga" id="harga" class="form-control"
                   value="{{ old('harga', 'Rp ' . number_format($kambing->harga, 0, ',', '.')) }}" required>
        </div>

        {{-- Stok --}}
        <div class="form-group mb-3">
            <label for="stok">Stok</label>
            <input type="number" class="form-control" name="stok" value="{{ old('stok', $kambing->stok) }}" required>
        </div>

        {{-- Deskripsi --}}
        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $kambing->deskripsi) }}</textarea>
        </div>

        {{-- Foto --}}
        <div class="form-group mb-3">
            <label for="foto">Foto (opsional)</label>
            <input type="file" name="foto" class="form-control-file">
            @if ($kambing->foto)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $kambing->foto) }}" alt="Foto Kambing" width="120" style="border-radius:8px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-success">
            <i class="mdi mdi-content-save"></i> Perbarui
        </button>
        <a href="{{ route('admin.kambing.index') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Kembali
        </a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const beratInput = document.getElementById('berat');
    const hargaInput = document.getElementById('harga');

    beratInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^\d.]/g, '');
    });

    hargaInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        e.target.value = value ? 'Rp ' + Number(value).toLocaleString('id-ID') : '';
    });

    document.querySelector('form').addEventListener('submit', function() {
        beratInput.value = beratInput.value.replace(/[^\d.]/g, '');
        hargaInput.value = hargaInput.value.replace(/[^\d]/g, '');
    });
</script>
@endpush
