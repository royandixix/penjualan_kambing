<!-- resources/views/admin/layouts/sidebar.blade.php -->
<nav class="sidebar-nav">
    <ul id="sidebarnav">
        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.kambing.index') }}"
                aria-expanded="false">
                <i class="mdi mdi-view-dashboard"></i>
                <span class="hide-menu">Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.kambing.index') }}"
                aria-expanded="false">
                <i class="mdi mdi-account-network"></i>
                <span class="hide-menu">Manajemen Kambing</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.pengguna.index') }}"
                aria-expanded="false">
                <i class="mdi mdi-border-all"></i>
                <span class="hide-menu">Manajemen Pengguna</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.pesanan.index') }}"
                aria-expanded="false">
                <i class="mdi mdi-face"></i>
                <span class="hide-menu">Pesanan Masuk</span>
            </a>
        </li>
        

        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="starter-kit.html" aria-expanded="false">
                <i class="mdi mdi-file"></i>
                <span class="hide-menu">Pembayaran</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="error-404.html" aria-expanded="false">
                <i class="mdi mdi-alert-outline"></i>
                <span class="hide-menu">Laporan</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="authentication-login.html"
                aria-expanded="false">
                <i class="mdi mdi-login"></i>
                <span class="hide-menu">Pengaturan</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="authentication-register.html"
                aria-expanded="false">
                <i class="mdi mdi-account-plus"></i>
                <span class="hide-menu">Register</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                aria-expanded="false">
                <i class="mdi mdi-logout"></i>
                <span class="hide-menu">Logout</span>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>




    </ul>
</nav>
