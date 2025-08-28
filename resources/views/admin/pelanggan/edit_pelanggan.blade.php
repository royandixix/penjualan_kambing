@extends('admin.layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Edit Pelanggan</h4>

    <!-- Form Edit Pelanggan -->
    <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Penting untuk update -->

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" required>
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $pelanggan->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" required>
            @error('no_hp')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
            @error('alamat')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Kembali
        </a>
    </form>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-center",
        "timeOut": "3000"
    };

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @elseif (session('error'))
        toastr.error("{{ session('error') }}");
    @elseif (session('warning'))
        toastr.warning("{{ session('warning') }}");
    @elseif (session('info'))
        toastr.info("{{ session('info') }}");
    @endif
</script>
@endsection
