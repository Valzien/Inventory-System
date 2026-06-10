<div id="sidebar">
    <div class="sidebar-wrapper active">

        <div class="sidebar-header position-relative">
            <div class="logo">
                <h4>Inventory System</h4>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">

                <li class="sidebar-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="/" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('barang*') ? 'active' : '' }}">
                    <a href="/barang" class="sidebar-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Data Barang</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('transaksi*') ? 'active' : '' }}">
                    <a href="/transaksi" class="sidebar-link">
                        <i class="bi bi-arrow-left-right"></i>
                        <span>Transaksi</span>
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

            </ul>
        </div>

    </div>
</div>