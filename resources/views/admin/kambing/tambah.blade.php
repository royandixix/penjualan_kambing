@extends('admin.layouts.app')

@section('title', 'Tambah Kambing')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">Tambah Data Kambing</h4>

        {{-- Form Tambah Kambing --}}
        <form action="{{ route('admin.kambing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="jenis_kambing">Jenis Kambing</label>
                <input type="text" name="jenis_kambing" class="form-control" value="{{ old('jenis_kambing') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="umur">Umur (bulan)</label>
                <input type="number" name="umur" class="form-control" value="{{ old('umur') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="berat">Berat</label>
                <div class="input-group">
                    <input type="text" name="berat" id="berat" class="form-control" value="{{ old('berat') }}" placeholder="Contoh: 30" required>
                    <div class="input-group-append">
                        <span class="input-group-text">kg</span>
                    </div>
                </div>
            </div>
            

            <div class="form-group mb-3">
                <label for="jenis_kelamin">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                    <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>Betina</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="harga">Harga (Rp)</label>
                <input type="text" name="harga" id="harga" class="form-control" value="{{ old('harga') }}" placeholder="Contoh: 1500000" required>
            </div>

            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" name="stok" id="stok" value="{{ old('stok', $kambing->stok ?? 0) }}">
            </div>
            
            
            

            <div class="form-group mb-3">
                <label for="deskripsi">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="form-group mb-4">
                <label for="foto">Foto (opsional)</label>
                <input type="file" name="foto" class="form-control-file">
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

<style>
    #toast-container {
        bottom: 50px !important;
        top: 100px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }
</style>

@push('scripts')
<!-- jQuery dan Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-center",
        "timeOut": "3000"
    };

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if ($errors->any())
        toastr.error("Ada kesalahan pada input. Periksa kembali formulir!");
    @endif

    const beratInput = document.getElementById('berat');
    const hargaInput = document.getElementById('harga');

    beratInput.addEventListener('input', function(e) {
    let raw = e.target.value.replace(/[^\d.]/g, ''); 
    e.target.value = raw + 'kg';
});

    // Format harga jadi Rp
    hargaInput.addEventListener('input', function (e) {
        let raw = e.target.value.replace(/[^\d]/g, '');
        if (raw === '') {
            e.target.value = '';
        } else {
            e.target.value = 'Rp ' + Number(raw).toLocaleString('id-ID');
        }
    });

    // Sebelum submit, bersihkan Rp dan pastikan angka
    document.querySelector('form').addEventListener('submit', function () {
        hargaInput.value = hargaInput.value.replace(/[^\d]/g, '');
        beratInput.value = beratInput.value.replace(/[^\d.]/g, '');
    });
</script>
@endpush
