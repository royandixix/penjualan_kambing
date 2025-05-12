<!-- resources/views/admin/layouts/header.blade.php -->
<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- Logo Section -->
        <div class="navbar-header" data-logobg="skin6">
            <a class="navbar-brand" href="{{ url('dashboard') }}">
                <b class="logo-icon">
                    <img src="{{ asset('admin-template/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                    <img src="{{ asset('admin-template/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" />
                </b>
                <span class="logo-text">
                    <img src="{{ asset('admin-template/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                    <img src="{{ asset('admin-template/images/logo-light-text.png') }}" alt="homepage" class="light-logo" />
                </span>
            </a>
            <!-- Mobile toggle -->
            <a class="nav-toggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)">
                <i class="mdi mdi-menu"></i>
            </a>
        </div>

        <!-- Navbar Content -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <!-- Left Nav -->
            <ul class="navbar-nav float-start me-auto">
                <!-- Search -->
                <li class="nav-item search-box">
                    <a class="nav-link waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-magnify me-1"></i>
                        <span class="font-16">Search</span>
                    </a>
                    <form class="app-search position-absolute">
                        <input type="text" class="form-control" placeholder="Search &amp; enter" />
                        <a class="srh-btn"><i class="mdi mdi-window-close"></i></a>
                    </form>
                </li>
            </ul>

            <!-- Right Nav -->
            
            <ul class="navbar-nav float-end">
                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                       href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="images/users/profile.png" alt="user" class="rounded-circle" width="31" />
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
