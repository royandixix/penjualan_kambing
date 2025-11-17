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
        /* Tinggi header */
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
        font-size: 16px; /* lebih kecil */
        font-weight: 600;
        color: #2d6a4f;
        margin-left: 5px; /* jarak lebih dekat ke logo */
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- Logo -->
        <div class="navbar-header" data-logobg="skin6">
            <a class="navbar-brand" href="{{ url('dashboard') }}">
                <!-- Logo gambar -->
                <b class="logo-icon">
                    <img src="{{ asset('img/logo.jpeg') }}" alt="homepage" class="dark-logo" style="height:40px; width:auto;" />
                </b>

                <!-- Teks di samping logo -->
                <span class="logo-text">Ternak_Kamberu</span>
            </a>

            <!-- Tombol toggle untuk mobile -->
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
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
