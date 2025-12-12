<!-- ===== Custom Navbar Styles ===== -->
<style>
    /* Main Navbar Container */
    .navbar-custom {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        z-index: 999;
    }

    /* Brand/Logo Section */
    .navbar-brand {
        font-weight: 700;
        font-size: 1.3rem;
        color: #343a40 !important;
        display: flex;
        align-items: center;
    }

    .navbar-brand img {
        height: 40px;
        margin-right: 0.5rem;
        border-radius: 0.25rem;
    }

    /* Toggle Button */
    .navbar-toggler {
        border: none;
        box-shadow: none !important;
    }

    /* Navigation Links */
    .navbar-nav .nav-link {
        display: flex;
        align-items: center;
        font-weight: 500;
        color: #333;
        position: relative;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
    }

    .navbar-nav .nav-link:hover {
        color: #198754;
    }

    /* Underline Animation on Hover */
    .navbar-nav .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 4px;
        left: 0;
        background-color: #198754;
        transition: width 0.3s ease;
    }

    .navbar-nav .nav-link:hover::after {
        width: 100%;
    }

    /* Dropdown Menu */
    .dropdown-menu {
        border-radius: 0.75rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        animation: fadeInDown 0.3s ease;
        background-color: #fff;
        padding: 0.5rem;
    }

    .dropdown-item {
        font-weight: 500;
        transition: background-color 0.2s ease, color 0.2s ease;
        border-radius: 0.5rem;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #198754;
    }

    .dropdown-item.text-danger:hover {
        background-color: #f8d7da;
        color: #dc3545;
    }

    /* Notification Badge */
    .notification-badge {
        position: absolute;
        top: 0;
        start: 100%;
        transform: translate(-50%, -50%);
    }

    /* Notification Dropdown Custom Width */
    .notification-dropdown {
        width: 300px;
        max-height: 350px;
        overflow-y: auto;
    }

    /* Animation */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== Responsive Styles ===== */
    @media (max-width: 992px) {
        .navbar-collapse {
            background-color: #fff;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .navbar-nav .nav-link {
            padding-left: 1rem;
        }

        .dropdown-menu {
            position: static !important;
            width: 100%;
            box-shadow: none;
            animation: none;
            padding: 0;
        }

        .notification-dropdown {
            width: 100%;
        }
    }
</style>
<!-- ===== Navbar HTML ===== -->
<nav class="navbar navbar-expand-lg navbar-custom px-4 py-3 mb-4 sticky-top">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('user.index') }}">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Ternak Kamberu Logo">
            <span class="fs-6">Ternak Kamberu</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar -->
        <div class="collapse navbar-collapse" id="navbarUser">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <!-- Beli Kambing -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.kambing') }}">
                        <i class="bi bi-box-seam me-1 text-success"></i> Beli Kambing
                    </a>
                </li>

                <!-- Keranjang -->
                <li class="nav-item position-relative">
                    <a class="nav-link" href="{{ route('user.keranjang.index') }}">
                        <i class="bi bi-cart-fill me-1 text-success fs-5"></i> Keranjang
                    </a>
                </li>

                <!-- Riwayat -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.riwayat') }}">
                        <i class="bi bi-clock-history me-1 text-success"></i> Riwayat
                    </a>
                </li>

                <!-- Notifikasi -->
                <li class="nav-item dropdown position-relative">

                    @php
                        $notifCount = Auth::check() ? Auth::user()->unreadNotifications->count() : 0;
                        $notifications = Auth::check()
                            ? Auth::user()->notifications()->orderBy('created_at', 'desc')->take(10)->get()
                            : collect();
                    @endphp

                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        <i class="bi bi-bell-fill text-success fs-5"></i>

                        @if ($notifCount > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $notifCount }}
                            </span>
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown p-2">

                        <h6 class="dropdown-header">Notifikasi</h6>

                        @forelse($notifications as $notif)
                            <li class="dropdown-item small {{ $notif->read_at ? '' : 'fw-bold' }}">
                                <a href="#" class="text-decoration-none text-dark">
                                    {{ $notif->data['title'] ?? 'Notifikasi' }}<br>
                                    <span class="text-muted small">{{ $notif->data['message'] ?? '' }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="dropdown-item text-center text-muted">Tidak ada notifikasi</li>
                        @endforelse

                        <li>
                            <hr>
                        </li>

                        <li>
                            <a href="{{ route('user.notifikasi.readAll') }}"
                                class="dropdown-item text-center text-primary">
                                Tandai semua dibaca
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Akun -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1 text-success"></i> Akun
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="px-3">
                                @csrf
                                <button class="dropdown-item text-danger d-flex align-items-center" type="submit">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
