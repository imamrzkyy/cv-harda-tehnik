<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLogin = isset($_SESSION['login']) && $_SESSION['login'] === true;

include_once __DIR__ . '/../config/helper.php';
include_once __DIR__ . '/../config/koneksi.php'; // Pastikan koneksi database tersedia untuk query foto jika diperlukan

// Ambil data foto user terbaru jika sudah login
$foto_user = '';
if ($isLogin && isset($_SESSION['id_user'])) {
    $id_user_nav = $_SESSION['id_user'];
    $q_nav_foto = mysqli_query($koneksi, "SELECT foto, nama FROM user WHERE id_user = '$id_user_nav'");
    if ($q_nav_foto && mysqli_num_rows($q_nav_foto) > 0) {
        $d_nav = mysqli_fetch_assoc($q_nav_foto);
        $foto_user = $d_nav['foto'] ?? '';
        // Sinkronkan nama di session jika berubah
        if (!empty($d_nav['nama'])) {
            $_SESSION['nama'] = $d_nav['nama'];
        }
    }
}
?>

<nav class="navbar navbar-expand-lg custom-navbar">

    <div class="container">

        <a class="navbar-brand text-primary fw-bold" href="<?= $base_url ?>index.php">
            CV. HARDA TEHNIK MANDIRI
        </a>

        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>index.php#tentang">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>index.php#layanan">Layanan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>index.php#produk">Produk</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>index.php#testimoni"> Testimoni
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= $base_url ?>index.php#kontak">Kontak</a>
                </li>

            </ul>

            <div class="d-flex ms-lg-4 mt-3 mt-lg-0">

                <?php if ($isLogin) { ?>

                <div class="dropdown">

                    <!-- Tombol Dropdown dengan Foto Profil Dinamis -->
                    <button class="btn btn-light border dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 rounded-pill shadow-sm"
                        data-bs-toggle="dropdown" style="background-color: #f8f9fa;">
                        
                        <?php if (!empty($foto_user) && file_exists(__DIR__ . '/../uploads/foto/' . $foto_user)): ?>
                            <img src="<?= $base_url ?>uploads/foto/<?= $foto_user; ?>" class="rounded-circle shadow-sm" style="width: 28px; height: 28px; object-fit: cover;" alt="Foto">
                        <?php else: ?>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 28px; height: 28px; font-size: 12px;">
                                <?= strtoupper(substr($_SESSION['nama'] ?? 'U', 0, 1)); ?>
                            </div>
                        <?php endif; ?>

                        <span class="fw-semibold text-dark small pe-1"><?= htmlspecialchars($_SESSION['nama']); ?></span>

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">

                        <li>
                            <a class="dropdown-item py-2"
                                href="<?= $base_url ?>user/profil.php">

                                <i class="bi bi-person text-primary me-2"></i>
                                Profil Saya

                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item py-2"
                                href="<?= $base_url ?>user/booking.php">

                                <i class="bi bi-plus-circle text-success me-2"></i>
                                Booking Service

                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item py-2"
                                href="<?= $base_url ?>user/booking_saya.php">

                                <i class="bi bi-calendar-check text-info me-2"></i>
                                Booking Saya

                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item py-2"
                                href="<?= $base_url ?>user/riwayat_booking.php">

                                <i class="bi bi-clock-history text-secondary me-2"></i>
                                Riwayat Booking

                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item py-2 text-danger"
                                href="<?= $base_url ?>user/logout.php">

                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout

                            </a>
                        </li>

                    </ul>

                </div>

                <?php } else { ?>

                <a href="<?= $base_url ?>user/login.php"
                    class="btn btn-outline-primary me-2">

                    Masuk

                </a>

                <a href="<?= $base_url ?>user/register.php"
                    class="btn btn-primary">

                    Daftar

                </a>

                <?php } ?>

            </div>

        </div>

    </div>

</nav>