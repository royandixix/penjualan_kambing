@extends('admin.layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">
                    <i class="bi bi-bell-fill text-primary me-2"></i>
                    Notifikasi
                </h3>
                
                <div class="btn-group">
                    @if($notifs->where('read_at', null)->count() > 0)
                        <a href="{{ route('admin.notifikasi.readAll') }}" 
                           class="btn btn-success btn-sm">
                            <i class="bi bi-check2-all"></i> Tandai Semua Dibaca
                        </a>
                    @endif
                    
                    @if($notifs->count() > 0)
                        <form action="{{ route('admin.notifikasi.deleteAll') }}" 
                              method="POST" 
                              onsubmit="return confirm('Hapus semua notifikasi?')"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> Hapus Semua
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Notifikasi Card -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    @forelse($notifs as $notif)
                        <div class="notif-item {{ is_null($notif->read_at) ? 'unread' : '' }}">
                            <div class="row align-items-start">
                                <div class="col-auto">
                                    <div class="notif-icon">
                                        @if(isset($notif->data['type']))
                                            @if($notif->data['type'] == 'pesanan')
                                                <i class="bi bi-cart-check-fill"></i>
                                            @elseif($notif->data['type'] == 'pembayaran')
                                                <i class="bi bi-credit-card-fill"></i>
                                            @else
                                                <i class="bi bi-info-circle-fill"></i>
                                            @endif
                                        @else
                                            <i class="bi bi-bell-fill"></i>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="col">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="fw-bold mb-1">
                                            {{ $notif->data['title'] ?? 'Notifikasi' }}
                                        </h6>
                                        @if(is_null($notif->read_at))
                                            <span class="badge bg-primary">Baru</span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-muted mb-2">
                                        {{ $notif->data['message'] ?? 'Tidak ada pesan' }}
                                    </p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-clock"></i> 
                                            {{ $notif->created_at->diffForHumans() }}
                                        </small>
                                        
                                        <div class="btn-group btn-group-sm">
                                            @if(isset($notif->data['url']))
                                                <a href="{{ $notif->data['url'] }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="bi bi-eye"></i> Lihat
                                                </a>
                                            @endif
                                            
                                            @if(is_null($notif->read_at))
                                                <a href="{{ route('admin.notifikasi.read', $notif->id) }}" 
                                                   class="btn btn-outline-success btn-sm">
                                                    <i class="bi bi-check2"></i> Tandai Dibaca
                                                </a>
                                            @endif
                                            
                                            <form action="{{ route('admin.notifikasi.delete', $notif->id) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Hapus notifikasi ini?')"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        @if(!$loop->last)
                            <hr class="m-0">
                        @endif
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-bell-slash text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3 mb-0">Belum ada notifikasi</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($notifs->hasPages())
                <div class="mt-4">
                    {{ $notifs->links() }}
                </div>
            @endif

        </div>
    </div>
</div>

<style>
    .notif-item {
        padding: 1.25rem;
        transition: background-color 0.2s ease;
        border-left: 4px solid transparent;
    }

    .notif-item:hover {
        background-color: #f8f9fa;
    }

    .notif-item.unread {
        background-color: #e7f5ff;
        border-left-color: #0d6efd;
    }

    .notif-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
</style>
@endsection