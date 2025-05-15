<!-- ===== Custom Navbar Style (letakkan di <head>) ===== -->
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
        }
    
        .navbar-brand i {
            color: #198754;
        }
    
        .navbar-toggler {
            border: none;
            box-shadow: none !important;
        }
    
        .navbar-nav .nav-link {
            position: relative;
            font-weight: 500;
            color: #333;
            transition: color 0.3s ease;
        }
    
        .navbar-nav .nav-link:hover {
            color: #198754;
        }
    
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
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
    
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
    
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    
        .dropdown-item {
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
    
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #198754;
        }
    
        .dropdown-item.text-danger:hover {
            background-color: #f8d7da;
            color: #dc3545;
        }
    
        /* Responsive behavior */
        @media (max-width: 992px) {
            .dropdown-menu {
                position: static !important;
                float: none;
                width: 100%;
                margin-top: 0.5rem;
                animation: none;
                box-shadow: none;
                padding-left: 1rem;
            }
    
            .dropdown-menu .dropdown-item {
                padding-left: 0.5rem;
            }
    
            .navbar-nav .nav-link {
                text-align: left;
            }
    
            .dropdown-toggle::after {
                float: right;
                margin-top: 0.5rem;
            }
        }
    </style>
    
    <!-- ===== Navbar HTML ===== -->
    <nav id="navbar-example2" class="navbar navbar-expand-lg navbar-custom px-4 py-3 mb-4 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('user.index') }}">
                <i class="bi bi-house-heart-fill me-2 fs-5"></i> <span class="fs-6">Ternak Kamberu</span>
            </a>
    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUser"
                aria-controls="navbarUser" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse mt-3 mt-lg-0" id="navbarUser">
                <ul class="navbar-nav ms-auto gap-2 align-items-start">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.kambing') }}">
                            <i class="bi bi-box-seam me-1 text-success"></i> Beli Kambing
                        </a>
                    </li>
    
                    <li id="ikonKeranjang" class="nav-item position-relative">
                        <a class="nav-link" href="{{ route('user.keranjang.index') }}">
                            <i class="bi bi-cart-fill fs-5"></i> Keranjang
                        </a>
                    </li>
    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.riwayat') }}">
                            <i class="bi bi-clock-history me-1 text-success"></i> Riwayat
                        </a>
                    </li>
    
                    <!-- Dropdown Akun -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1 text-success"></i> Akun
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
    