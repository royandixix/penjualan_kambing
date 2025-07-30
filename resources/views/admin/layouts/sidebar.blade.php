<nav class="sidebar-nav sticky-sidebar">
    <ul id="sidebarnav">
        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.kambing.index') }}">
                <i class="mdi mdi-view-dashboard"></i> <span class="hide-menu">Dashboard</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.kambing.index') }}">
                <i class="mdi mdi-account-network"></i> <span class="hide-menu">Manajemen Kambing</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.pengguna.index') }}">
                <i class="mdi mdi-border-all"></i> <span class="hide-menu">Manajemen Pengguna</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.pesanan.index') }}">
                <i class="mdi mdi-face"></i> <span class="hide-menu">Pesanan Masuk</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.pembayaran.index') }}">
                <i class="mdi mdi-credit-card"></i> <span class="hide-menu">Pembayaran</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="{{ route('admin.laporan.index') }}">
                <i class="mdi mdi-alert-outline"></i> <span class="hide-menu">Laporan</span>
            </a>
        </li>

        <li class="sidebar-item">
            <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="mdi mdi-logout"></i> <span class="hide-menu">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</nav>
