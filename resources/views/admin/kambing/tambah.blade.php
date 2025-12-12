@extends('admin.layouts.app')

@section('title', 'Tambah Kambing')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Tambah Data Kambing</h4>

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

    <form action="{{ route('admin.kambing.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Jenis Kambing (menggunakan field kategori) --}}
        <div class="form-group mb-3">
            <label for="kategori">Jenis Kambing</label>
            <select name="kategori" class="form-control" required>
                <option value="">-- Pilih Jenis Kambing --</option>
                <option value="Kambing Kacang" {{ old('kategori') == 'Kambing Kacang' ? 'selected' : '' }}>Kambing Kacang</option>
                <option value="Kambing Peranakan Etawa" {{ old('kategori') == 'Kambing Peranakan Etawa' ? 'selected' : '' }}>Kambing Peranakan Etawa</option>
            </select>
        </div>

        {{-- Umur --}}
        <div class="form-group mb-3">
            <label for="umur">Umur (bulan)</label>
            <input type="number" name="umur" class="form-control" value="{{ old('umur') }}" required>
        </div>

        {{-- Berat --}}
        <div class="form-group mb-3">
            <label for="berat">Berat (kg)</label>
            <input type="text" name="berat" id="berat" class="form-control" value="{{ old('berat') }}" placeholder="Contoh: 30" required>
        </div>

        {{-- Jenis Kelamin --}}
        <div class="form-group mb-3">
            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih Jenis Kelamin --</option>
                <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>Betina</option>
            </select>
        </div>

        {{-- Harga --}}
        <div class="form-group mb-3">
            <label for="harga">Harga (Rp)</label>
            <input type="text" name="harga" id="harga" class="form-control" value="{{ old('harga') }}" placeholder="Contoh: 1500000" required>
        </div>

        {{-- Stok --}}
        <div class="form-group mb-3">
            <label for="stok">Stok</label>
            <input type="number" class="form-control" name="stok" id="stok" value="{{ old('stok', 0) }}" required>
        </div>

        {{-- Deskripsi --}}
        <div class="form-group mb-3">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
        </div>

        {{-- Foto --}}
        <div class="form-group mb-4">
            <label for="foto">Foto (opsional)</label>
            <input type="file" name="foto" class="form-control-file" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">
            <i class="mdi mdi-content-save"></i> Simpan
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
    
    // Fungsi untuk memformat harga menjadi format Rupiah (angka murni)
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^\d]/g, '').toString();
        return number_string ? Number(number_string).toLocaleString('id-ID') : '';
    }

    // Format berat (angka saja)
    beratInput.addEventListener('input', function(e) {
        // Hanya izinkan angka dan titik
        e.target.value = e.target.value.replace(/[^\d.]/g, '');
    });

    // Format harga otomatis Rupiah saat diketik
    hargaInput.addEventListener('input', function(e) {
        e.target.value = formatRupiah(e.target.value);
    });

    // Bersihkan format saat submit
    document.querySelector('form').addEventListener('submit', function() {
        // Hapus semua karakter non-digit dan titik dari Berat
        beratInput.value = beratInput.value.replace(/[^\d.]/g, ''); 
        // Hapus semua karakter non-digit dari Harga
        hargaInput.value = hargaInput.value.replace(/[^\d]/g, ''); 
    });
</script>
@endpush