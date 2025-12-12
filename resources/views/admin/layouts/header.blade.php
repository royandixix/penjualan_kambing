<!-- resources/views/admin/layouts/header.blade.php -->

<style>
    /* Sticky Header */
    .topbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1030;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .page-wrapper {
        margin-top: 70px;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
    }

    .navbar-brand .logo-icon img {
        height: 40px;
        width: auto;
    }

    .navbar-brand .logo-text {
        font-size: 16px;
        font-weight: 600;
        color: #2d6a4f;
        margin-left: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ===== Badge Notifikasi ===== */
    .notif-admin-badge {
        position: absolute;
        top: 5px;
        right: 4px;
        background: #dc3545;
        color: white;
        font-size: 10px;
        padding: 2px 6px;
        border-radius: 50%;
        font-weight: bold;
        line-height: normal;
        animation: pulse-badge 2s infinite;
    }

    @keyframes pulse-badge {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    /* ===== Dropdown Notifikasi ===== */
    .notif-dropdown-admin {
        min-width: 380px;
        max-width: 420px;
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15) !important;
        margin-top: 0.5rem;
    }

    .notif-dropdown-header {
        padding: 1rem;
        border-bottom: 2px solid #f0f0f0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 0.75rem 0.75rem 0 0;
    }

    .notif-scroll {
        max-height: 420px;
        overflow-y: auto;
        padding: 0.5rem;
    }

    .notif-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .notif-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .notif-scroll::-webkit-scrollbar-thumb {
        background: #667eea;
        border-radius: 10px;
    }

    .notif-scroll::-webkit-scrollbar-thumb:hover {
        background: #764ba2;
    }

    .notif-dropdown-item {
        padding: 0.85rem;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .notif-dropdown-item:hover {
        background-color: #f8f9fa;
        border-color: #e0e0e0;
        transform: translateX(3px);
    }

    .notif-dropdown-item.unread {
        background: linear-gradient(90deg, #e3f2fd 0%, #f3e5f5 100%);
        border-left: 4px solid #667eea;
    }

    .notif-icon-small {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .notif-title {
        font-weight: 600;
        font-size: 0.9rem;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .notif-message {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.4;
        margin-bottom: 0.25rem;
    }

    .notif-time {
        font-size: 0.75rem;
        color: #999;
    }

    .notif-badge-new {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 12px;
        font-weight: 600;
    }

    .notif-footer {
        padding: 0.75rem 1rem;
        border-top: 2px solid #f0f0f0;
        background-color: #fafafa;
        border-radius: 0 0 0.75rem 0.75rem;
    }

    .notif-footer a {
        color: #667eea;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .notif-footer a:hover {
        color: #764ba2;
        text-decoration: underline;
    }

    .notif-empty {
        padding: 3rem 1rem;
        text-align: center;
        color: #999;
    }

    .notif-empty i {
        font-size: 3.5rem;
        opacity: 0.5;
        margin-bottom: 1rem;
        display: block;
    }

    .btn-mark-all {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-mark-all:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notif-dropdown-admin {
            min-width: 320px;
            max-width: 95vw;
            left: 50% !important;
            transform: translateX(-50%) !important;
        }
        
        .notif-scroll {
            max-height: 350px;
        }
    }
</style>

<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">

        <!-- Logo -->
        <div class="navbar-header" data-logobg="skin6">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <b class="logo-icon">
                    <img src="{{ asset('img/logo.jpeg') }}" alt="homepage" class="dark-logo" style="height:40px; width:auto;" />
                </b>
                <span class="logo-text">Ternak_Kamberu</span>
            </a>

            <!-- Toggle Mobile -->
            <a class="nav-toggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)">
                <i class="mdi mdi-menu"></i>
            </a>
        </div>

        <!-- Navbar Content -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">

            <!-- Left Navbar -->
            <ul class="navbar-nav float-start me-auto">
                <li class="nav-item search-box">
                    <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-magnify me-1"></i>
                        <span class="font-16">Search</span>
                    </a>
                    <form class="app-search position-absolute">
                        <input type="text" class="form-control" placeholder="Search & enter" />
                        <a class="srh-btn"><i class="mdi mdi-window-close"></i></a>
                    </form>
                </li>
            </ul>

            <!-- Right Navbar -->
            <ul class="navbar-nav float-end">

                <!-- ===== NOTIFIKASI ADMIN DROPDOWN ===== -->
                @php
                    $unreadCount = auth()->check() ? auth()->user()->unreadNotifications->count() : 0;
                    $allNotifications = auth()->check() ? auth()->user()->notifications->take(5) : collect();
                @endphp

                <li class="nav-item dropdown position-relative">
                    <a class="nav-link waves-effect waves-dark" 
                       href="#" 
                       id="notifDropdownAdmin" 
                       role="button"
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        <i class="mdi mdi-bell-outline mdi-24px"></i>
                        
                        @if($unreadCount > 0)
                            <span class="notif-admin-badge">{{ $unreadCount }}</span>
                        @endif
                    </a>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end notif-dropdown-admin" aria-labelledby="notifDropdownAdmin">
                        
                        <!-- Header -->
                        <li class="notif-dropdown-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 fw-bold">Notifikasi</h6>
                                    <small style="opacity: 0.9;">{{ $unreadCount }} belum dibaca</small>
                                </div>
                                @if($unreadCount > 0)
                                    <a href="{{ route('admin.notifikasi.readAll') }}" class="btn-mark-all">
                                        Tandai Semua
                                    </a>
                                @endif
                            </div>
                        </li>

                        <!-- Notifikasi List -->
                        <div class="notif-scroll">
                            @forelse($allNotifications as $notif)
                                <li>
                                    <a href="{{ $notif->data['url'] ?? route('admin.notifikasi') }}" 
                                       class="notif-dropdown-item {{ is_null($notif->read_at) ? 'unread' : '' }} text-decoration-none"
                                       onclick="markAsRead('{{ $notif->id }}')">
                                        <div class="d-flex align-items-start">
                                            <div class="notif-icon-small me-3">
                                                @if(isset($notif->data['type']))
                                                    @if($notif->data['type'] == 'pesanan')
                                                        <i class="mdi mdi-cart-check"></i>
                                                    @elseif($notif->data['type'] == 'pembayaran')
                                                        <i class="mdi mdi-credit-card"></i>
                                                    @else
                                                        <i class="mdi mdi-information"></i>
                                                    @endif
                                                @else
                                                    <i class="mdi mdi-bell"></i>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <span class="notif-title">
                                                        {{ $notif->data['title'] ?? 'Notifikasi' }}
                                                    </span>
                                                    @if(is_null($notif->read_at))
                                                        <span class="notif-badge-new ms-2">Baru</span>
                                                    @endif
                                                </div>
                                                
                                                <p class="notif-message mb-1">
                                                    {{ Str::limit($notif->data['message'] ?? 'Tidak ada pesan', 80) }}
                                                </p>
                                                
                                                <div class="notif-time">
                                                    <i class="mdi mdi-clock-outline"></i> 
                                                    {{ $notif->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li class="notif-empty">
                                    <i class="mdi mdi-bell-off-outline"></i>
                                    <p class="mb-0">Belum ada notifikasi</p>
                                </li>
                            @endforelse
                        </div>

                        <!-- Footer -->
                        @if($allNotifications->count() > 0)
                            <li class="notif-footer text-center">
                                <a href="{{ route('admin.notifikasi') }}">
                                    Lihat Semua Notifikasi
                                    <i class="mdi mdi-arrow-right"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                <!-- Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                        href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('images/users/profile.png') }}" alt="user" class="rounded-circle" width="31" />
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="mdi mdi-account m-r-5 m-l-5"></i> My Profile
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="mdi mdi-wallet m-r-5 m-l-5"></i> My Balance
                        </a>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <i class="mdi mdi-email m-r-5 m-l-5"></i> Inbox
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="mdi mdi-power m-r-5 m-l-5"></i> Logout
                            </button>
                        </form>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
</header>

<script>
// Mark notification as read ketika diklik
function markAsRead(notifId) {
    fetch(`/admin/notifikasi/read/${notifId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    }).catch(error => console.log('Error marking as read:', error));
}

// Auto-refresh badge count setiap 30 detik (optional)
setInterval(function() {
    fetch('{{ route("admin.notifikasi") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const badge = document.querySelector('.notif-admin-badge');
        const newCount = doc.querySelectorAll('.notif-item.unread').length;
        
        if (badge) {
            if (newCount > 0) {
                badge.textContent = newCount;
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        } else if (newCount > 0) {
            const bellIcon = document.querySelector('#notifDropdownAdmin');
            if (bellIcon) {
                const newBadge = document.createElement('span');
                newBadge.className = 'notif-admin-badge';
                newBadge.textContent = newCount;
                bellIcon.appendChild(newBadge);
            }
        }
    })
    .catch(error => console.error('Error refreshing notifications:', error));
}, 30000); // Refresh setiap 30 detik
</script>