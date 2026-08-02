<!-- Sidebar -->
<div class="sidebar" id="sidebar">

    <div class="sidebar-brand">

        <img src="../assets/images/team/user8.jpg" alt="Logo">

        <div>

            <h5>CV. HARDA</h5>
            <small>Admin Panel</small>

        </div>

    </div>

    <ul class="sidebar-menu">

        <li>
            <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF'])=='dashboard.php' ? 'active' : '' ?>">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="booking.php" class="<?= basename($_SERVER['PHP_SELF'])=='booking.php' ? 'active' : '' ?>">
                <i class="bi bi-calendar-check"></i>
                Booking
            </a>
        </li>

        <li>
            <a href="produk.php" class="<?= basename($_SERVER['PHP_SELF'])=='produk.php' ? 'active' : '' ?>">
                <i class="bi bi-box-seam"></i>
                Produk
            </a>
        </li>

        <li>
            <a href="kategori.php" class="<?= basename($_SERVER['PHP_SELF'])=='kategori.php' ? 'active' : '' ?>">
                <i class="bi bi-tags"></i>
                Kategori
            </a>
        </li>

        <li>
            <a href="pelanggan.php" class="<?= basename($_SERVER['PHP_SELF'])=='pelanggan.php' ? 'active' : '' ?>">
                <i class="bi bi-people"></i>
                Pelanggan
            </a>
        </li>

        <li>
            <a href="testimoni.php" class="<?= basename($_SERVER['PHP_SELF'])=='testimoni.php' ? 'active' : '' ?>">
                <i class="bi bi-chat-left-text"></i>
                Testimoni
            </a>
        </li>

        <li>
            <a href="laporan.php" class="<?= basename($_SERVER['PHP_SELF'])=='laporan.php' ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-bar-graph"></i>
                Laporan
            </a>
        </li>

    </ul>

    <div class="sidebar-footer">

        <a href="logout.php" class="logout-btn">

            <i class="bi bi-box-arrow-right"></i>

            Logout

        </a>

    </div>

</div>