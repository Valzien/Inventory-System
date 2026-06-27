<div id="sidebar">
    <div class="sidebar-wrapper active">

        <div class="sidebar-header position-relative">
            <div class="logo">
                <h4 class="mb-0">Inventory</h4>
                <small class="text-muted">PT. Iklima Sukses Mandiri</small>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu d-flex flex-column" style="min-height: 82vh;">

                {{-- DASHBOARD --}}
                <li class="sidebar-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="/" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- ADMIN MENU --}}
                @if(auth()->user()->role == 'admin')

                    <li class="sidebar-title">Master Data</li>

                    <li class="sidebar-item {{ request()->is('barang*') ? 'active' : '' }}">
                        <a href="/barang" class="sidebar-link">
                            <i class="bi bi-box-seam"></i>
                            <span>Data Part</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('kategori-part*') ? 'active' : '' }}">
                        <a href="/kategori-part" class="sidebar-link">
                            <i class="bi bi-tags"></i>
                            <span>Kategori Part</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('supplier*') ? 'active' : '' }}">
                        <a href="/supplier" class="sidebar-link">
                            <i class="bi bi-truck"></i>
                            <span>Supplier</span>
                        </a>
                    </li>

                    <li class="sidebar-title">Inventory</li>

                    <li class="sidebar-item {{ request()->is('transaksi*') ? 'active' : '' }}">
                        <a href="/transaksi" class="sidebar-link">
                            <i class="bi bi-arrow-left-right"></i>
                            <span>Transaksi</span>
                        </a>
                    </li>

                @endif

                {{-- MANPURCHASE MENU --}}
                @if(auth()->user()->role == 'manpurchase')

                    <li class="sidebar-title">Approval</li>

                    <li class="sidebar-item {{ request()->is('approval*') ? 'active' : '' }}">
                        <a href="/approval" class="sidebar-link">
                            <i class="bi bi-check-circle"></i>
                            <span>Approval</span>
                        </a>
                    </li>

                    <li class="sidebar-title">Laporan</li>

                    <li class="sidebar-item {{ request()->is('laporan*') ? 'active' : '' }}">
                        <a href="/laporan" class="sidebar-link">
                            <i class="bi bi-file-earmark-text"></i>
                            <span>Laporan</span>
                        </a>
                    </li>

                @endif

                {{-- DIREKTUR MENU --}}
                @if(auth()->user()->role == 'direktur')

                    <li class="sidebar-title">Manajemen</li>

                    <li class="sidebar-item {{ request()->is('direktur/user-management*') ? 'active' : '' }}">
                        <a href="/direktur/user-management" class="sidebar-link">
                            <i class="bi bi-people"></i>
                            <span>Manajemen User</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('approval*') ? 'active' : '' }}">
                        <a href="/approval" class="sidebar-link">
                            <i class="bi bi-check-circle"></i>
                            <span>Approval</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('laporan*') ? 'active' : '' }}">
                        <a href="/laporan" class="sidebar-link">
                            <i class="bi bi-file-earmark-text"></i>
                            <span>Laporan</span>
                        </a>
                    </li>

                @endif

                {{-- ACCOUNT MENU --}}
                <li class="sidebar-title mt-4">
                    Akun
                </li>

                <li class="sidebar-item {{ request()->is('profile*') ? 'active' : '' }}">
                    <a href="/profile" class="sidebar-link">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>

                <li class="sidebar-item sidebar-logout">

                    <form action="/logout" method="POST">
                        @csrf

                        <button
                            type="submit"
                            class="sidebar-link border-0 bg-transparent w-100 text-start"
                        >
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </button>
                    </form>

                </li>

            </ul>
        </div>

    </div>
</div>