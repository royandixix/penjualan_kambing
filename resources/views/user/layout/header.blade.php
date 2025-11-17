<!-- ===== Custom Navbar Style ===== -->
<style>
    .navbar-custom {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        z-index: 999;
    }

    .navbar-brand {
        font-weight: 700;
        font-size: 1.3rem;
        color: #343a40 !important;
        display: flex;
        align-items: center;
    }

    .navbar-brand img {
        height: 40px; /* ukuran logo */
        margin-right: 0.5rem;
        border-radius: 0.25rem; /* opsional */
    }

    .navbar-toggler {
        border: none;
        box-shadow: none !important;
    }

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
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #198754;
    }

    .dropdown-item.text-danger:hover {
        background-color: #f8d7da;
        color: #dc3545;
    }

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
    }
</style>

<!-- ===== Navbar HTML ===== -->
<nav class="navbar navbar-expand-lg navbar-custom px-4 py-3 mb-4 sticky-top">
    <div class="container-fluid">
        <!-- Logo / Brand -->
        <a class="navbar-brand" href="{{ route('user.index') }}">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Ternak Kamberu Logo">
            <span class="fs-6">Ternak Kamberu</span>
        </a>

        
        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser"
            aria-controls="navbarUser" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarUser">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <!-- Beli Kambing -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.kambing') }}">
                        <i class="bi bi-box-seam me-1 text-success"></i>
                        <span>Beli Kambing</span>
                    </a>
                </li>

                <!-- Keranjang -->
                <li class="nav-item position-relative" id="ikonKeranjang">
                    <a class="nav-link" href="{{ route('user.keranjang.index') }}">
                        <i class="bi bi-cart-fill me-1 text-success fs-5"></i>
                        <span>Keranjang</span>
                    </a>
                </li>

                <!-- Riwayat -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.riwayat') }}">
                        <i class="bi bi-clock-history me-1 text-success"></i>
                        <span>Riwayat</span>
                    </a>
                </li>

                <!-- Dropdown Akun -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1 text-success"></i>
                        <span>Akun</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
