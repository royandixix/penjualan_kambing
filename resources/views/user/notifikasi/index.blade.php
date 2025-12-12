@extends('user.layouts.app')

@section('title', 'Notifikasi Transaksi')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-3">🔔 Notifikasi Transaksi</h4>

    <div class="list-group">
        @forelse($notifications as $notif)
            <div class="list-group-item">
                <strong>{{ $notif->data['message'] }}</strong><br>
                <small class="text-muted">{{ $notif->data['tanggal'] }}</small>
            </div>
        @empty
            <p class="text-muted">Belum ada notifikasi.</p>
        @endforelse
    </div>
</div>
@endsection
