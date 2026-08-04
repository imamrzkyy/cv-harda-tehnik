<?php
session_start();

$isLogin = isset($_SESSION['login']) && $_SESSION['login'] === true;

include "config/koneksi.php";
include "includes/header.php";
include "includes/navbar.php";
?>

<!-- =========================================
                HERO
========================================== -->
<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <!-- Text -->
            <div class="col-lg-6 order-1 order-lg-1">

                <span class="hero-badge">
                    <i class="bi bi-patch-check-fill"></i>
                    Teknisi Profesional & Bergaransi
                </span>

                <h1 class="hero-title">
                    Solusi Profesional
                    <span>Service & Perawatan AC</span>
                </h1>

                <p class="hero-text">

                    Rumah AC Harda Tehnik Mandiri melayani jasa
                    Service AC, Cuci AC, Perbaikan AC,
                    Bongkar Pasang AC, Isi Freon,
                    serta Penjualan AC Baru & Bekas
                    dengan teknisi yang berpengalaman.

                </p>

                <div class="hero-button">

                    <?php if($isLogin): ?>

                        <a href="user/booking.php" class="btn btn-light btn-lg">
                            Booking Sekarang
                        </a>

                        <?php else: ?>

                        <button type="button" class="btn btn-light btn-lg" onclick="harusLogin()"> Booking Sekarang
                        </button>

                        <?php endif; ?>

                    <a href="#layanan" class="btn btn-outline-light btn-lg">

                        Lihat Layanan

                    </a>

                </div>

                <ul class="hero-list mt-4">

                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Service AC
                    </li>

                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Cuci AC
                    </li>

                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Isi Freon
                    </li>

                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Bongkar Pasang
                    </li>

                </ul>

            </div>

            <!-- Image -->
            <div class="col-lg-6 text-center order-2 order-lg-2">

                <img
                    src="<?= $base_url ?>assets/images/hero/gambar teknisi.png"
                    class="img-fluid hero-image"
                    alt="Hero">

            </div>

        </div>

    </div>

</section>

<!-- =========================================
            COUNTER
========================================== -->

<section class="counter-section">

    <div class="container">

        <div class="row g-4">

            <div class="col-lg-3 col-md-6">

                <div class="counter-box">

                    <div class="counter-icon">

                        <i class="bi bi-tools"></i>

                    </div>

                    <h2>1500+</h2>

                    <p>Service Selesai</p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="counter-box">

                    <div class="counter-icon">

                        <i class="bi bi-people-fill"></i>

                    </div>

                    <h2>350+</h2>

                    <p>Pelanggan</p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="counter-box">

                    <div class="counter-icon">

                        <i class="bi bi-award-fill"></i>

                    </div>

                    <h2>10+</h2>

                    <p>Tahun Pengalaman</p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="counter-box">

                    <div class="counter-icon">

                        <i class="bi bi-shield-check"></i>

                    </div>

                    <h2>100%</h2>

                    <p>Garansi</p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- =========================================
            TENTANG KAMI
========================================== -->

<section id="tentang">

    <div class="container">

        <div class="row align-items-center g-5">

            <!-- Gambar -->

            <div class="col-lg-6">

                <div class="about-image">

                    <img
                        src="<?= $base_url ?>assets/images/team/tentang saya CV.png"
                        class="img-fluid rounded-4"
                        alt="Tentang Kami">

                    <div class="experience-box">

                        <h2>10+</h2>

                        <p>Tahun Pengalaman</p>

                    </div>

                </div>

            </div>

            <!-- Isi -->

            <div class="col-lg-6">

                <div class="about-content">

                    <span>TENTANG KAMI</span>

                    <h2>

                        RUMAH AC HARDA TEHNIK MANDIRI

                    </h2>

                    <p>

                        Rumah AC Harda Tehnik Mandiri merupakan perusahaan
                        yang bergerak di bidang jasa service,
                        perawatan, pemasangan,
                        bongkar pasang, isi freon,
                        serta penjualan AC baru
                        dan AC bekas.

                    </p>

                    <p>

                        Kami selalu mengutamakan kualitas pekerjaan,
                        ketepatan waktu,
                        dan kepuasan pelanggan.
                        Seluruh teknisi kami
                        memiliki pengalaman,
                        profesional,
                        dan menggunakan peralatan modern.

                    </p>

                    <ul class="about-list">

                        <li>

                            <i class="bi bi-check-circle-fill"></i>

                            Teknisi Profesional

                        </li>

                        <li>

                            <i class="bi bi-check-circle-fill"></i>

                            Harga Transparan

                        </li>

                        <li>

                            <i class="bi bi-check-circle-fill"></i>

                            Bergaransi

                        </li>

                        <li>

                            <i class="bi bi-check-circle-fill"></i>

                            Fast Response

                        </li>

                    </ul>

                    <a href="#layanan" class="btn btn-primary mt-4">

                        Lihat Semua Layanan

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- =========================================
                LAYANAN
========================================== -->
<section id="layanan">

    <div class="container">

        <div class="section-title">

            <span>Layanan</span>

            <h2>Layanan Kami</h2>

            <p>
                Kami memberikan berbagai layanan terbaik untuk kebutuhan
                pendingin ruangan rumah, kantor maupun industri.
            </p>

        </div>

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">

                <div class="service-card">

                    <div class="service-icon">
                        <i class="bi bi-tools"></i>
                    </div>

                    <h4>Service AC</h4>

                    <p>
                        Pemeriksaan dan perbaikan AC agar kembali dingin,
                        hemat listrik dan bekerja secara optimal.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="service-card">

                    <div class="service-icon">
                        <i class="bi bi-droplet-half"></i>
                    </div>

                    <h4>Cuci AC</h4>

                    <p>
                        Membersihkan evaporator dan kondensor
                        agar udara lebih sehat serta AC tetap dingin.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="service-card">

                    <div class="service-icon">
                        <i class="bi bi-thermometer-sun"></i>
                    </div>

                    <h4>Isi Freon</h4>

                    <p>
                        Pengisian freon R22, R32 maupun R410A
                        menggunakan alat profesional.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="service-card">

                    <div class="service-icon">
                        <i class="bi bi-house-gear-fill"></i>
                    </div>

                    <h4>Bongkar Pasang AC</h4>

                    <p>
                        Bongkar dan pemasangan AC baru
                        maupun pindahan rumah dengan aman.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="service-card">

                    <div class="service-icon">
                        <i class="bi bi-wrench-adjustable-circle"></i>
                    </div>

                    <h4>Perbaikan AC</h4>

                    <p>
                        Mengatasi AC bocor,
                        mati total,
                        tidak dingin,
                        hingga kerusakan kompresor.
                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="service-card">

                    <div class="service-icon">
                        <i class="bi bi-snow"></i>
                    </div>

                    <h4>Jual AC</h4>

                    <p>
                        Menyediakan AC baru dan bekas
                        dari berbagai merek dengan garansi.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- =========================================
            KEUNGGULAN
========================================== -->

<section id="keunggulan">

    <div class="container">

        <div class="section-title text-white">

            <span class="text-white">
                Mengapa Kami?
            </span>

            <h2 class="text-white">
                Kenapa Memilih Kami
            </h2>

            <p class="text-light">

                Kami selalu memberikan pelayanan terbaik
                dengan kualitas pekerjaan yang terjamin.

            </p>

        </div>

        <div class="row g-4">

            <div class="col-lg-4 col-md-6">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="bi bi-person-check-fill"></i>
                    </div>

                    <h5>Teknisi Berpengalaman</h5>

                    <p>

                        Teknisi berpengalaman
                        dalam menangani berbagai jenis AC.

                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="bi bi-lightning-charge-fill"></i>
                    </div>

                    <h5>Fast Response</h5>

                    <p>

                        Respon cepat
                        dan siap datang ke lokasi pelanggan.

                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>

                    <h5>Garansi Service</h5>

                    <p>

                        Seluruh pekerjaan
                        mendapatkan garansi sesuai ketentuan.

                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <h5>Harga Transparan</h5>

                    <p>

                        Tidak ada biaya tersembunyi.
                        Semua dijelaskan sebelum pengerjaan.

                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="bi bi-tools"></i>
                    </div>

                    <h5>Peralatan Modern</h5>

                    <p>

                        Menggunakan alat kerja profesional
                        agar hasil lebih maksimal.

                    </p>

                </div>

            </div>

            <div class="col-lg-4 col-md-6">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <h5>Datang ke Lokasi</h5>

                    <p>

                        Melayani rumah,
                        kantor,
                        toko,
                        apartemen,
                        dan gedung.

                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- =========================================
            PRODUK
========================================== -->

<section id="produk">

    <div class="container">

        <div class="section-title">

            <span>Produk</span>

            <h2>Produk AC Unggulan</h2>

            <p>

                Kami menyediakan AC baru dan bekas
                dengan kualitas terbaik serta bergaransi.

            </p>

        </div>

        <div class="row g-4">

<?php

$query = mysqli_query($koneksi, "
    SELECT *
    FROM produk
    WHERE status='Tersedia'
    ORDER BY id_produk DESC
    LIMIT 3
");

while($p = mysqli_fetch_assoc($query)){

?>

    <div class="col-lg-4 col-md-6">

        <div class="product-card">

            <div class="product-image">

                <img src="uploads/produk/<?= $p['gambar']; ?>"
                     class="img-fluid"
                     alt="<?= htmlspecialchars($p['nama_produk']); ?>">

                <span class="product-badge">
                    <?= $p['kondisi']; ?>
                </span>

            </div>

            <div class="product-body">

                <h5 class="product-title">
                    <?= htmlspecialchars($p['nama_produk']); ?>
                </h5>

                <small class="text-muted">
                    <?= htmlspecialchars($p['merk']); ?> • <?= htmlspecialchars($p['pk_ac']); ?>
                </small>

                <div class="product-price mt-2">
                    Rp <?= number_format($p['harga'],0,',','.'); ?>
                </div>

                <a href="detail_produk.php?id=<?= $p['id_produk']; ?>"
                   class="btn btn-primary w-100 mt-3">

                    Detail Produk

                </a>

            </div>

        </div>

    </div>

<?php } ?>

</div>

        <div class="text-center mt-5">
            <a href="produk.php" class="btn btn-success btn-lg">
                Lihat Semua Produk
            </a>
        </div>

    </div>

</section>

<!-- =========================================
            CARA BOOKING
========================================== -->

<section id="booking">

    <div class="container">

        <div class="section-title">

            <span>Booking</span>

            <h2>Cara Booking Layanan</h2>

            <p>

                Hanya dengan beberapa langkah mudah,
                teknisi kami siap datang ke lokasi Anda.

            </p>

        </div>

        <div class="row g-4 justify-content-center">

            <div class="col-lg col-md-4 col-6">

                <div class="feature-card text-center">

                    <div class="feature-icon">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>

                    <h5>Daftar</h5>

                    <p>Buat akun terlebih dahulu.</p>

                </div>

            </div>

            <div class="col-lg col-md-4 col-6">

                <div class="feature-card text-center">

                    <div class="feature-icon">
                        <i class="bi bi-tools"></i>
                    </div>

                    <h5>Pilih Layanan</h5>

                    <p>Pilih layanan yang dibutuhkan.</p>

                </div>

            </div>

            <div class="col-lg col-md-4 col-6">

                <div class="feature-card text-center">

                    <div class="feature-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <h5>Isi Booking</h5>

                    <p>Lengkapi formulir pemesanan.</p>

                </div>

            </div>

            <div class="col-lg col-md-6 col-6">

                <div class="feature-card text-center">

                    <div class="feature-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <h5>Konfirmasi</h5>

                    <p>Admin akan menghubungi Anda.</p>

                </div>

            </div>

            <div class="col-lg col-md-6 col-12">

                <div class="feature-card text-center">

                    <div class="feature-icon">
                        <i class="bi bi-house-check-fill"></i>
                    </div>

                    <h5>Teknisi Datang</h5>

                    <p>Pekerjaan dilakukan sesuai jadwal.</p>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- =========================================
                GALERI
========================================== -->

<section id="galeri" class="bg-light">

    <div class="container">

        <div class="section-title">

            <span>Galeri</span>

            <h2>Dokumentasi Pekerjaan</h2>

            <p>
                Beberapa hasil pekerjaan teknisi
                Rumah AC Harda Tehnik Mandiri.
            </p>

        </div>

        <div class="row g-4">

            <?php

            $queryGaleri = mysqli_query($koneksi, "
                SELECT *
                FROM galeri
                ORDER BY id_galeri DESC
            ");

            while($galeri = mysqli_fetch_assoc($queryGaleri)):

            ?>

            <div class="col-lg-4 col-md-6">

                <div class="gallery-item">

                    <img
                        src="<?= $base_url ?>assets/images/galeri/<?= htmlspecialchars($galeri['gambar']); ?>"
                        class="img-fluid"
                        alt="<?= htmlspecialchars($galeri['judul']); ?>">

                    <div class="gallery-overlay">

                        <h5 class="text-white fw-bold mb-1">
                            <?= htmlspecialchars($galeri['judul']); ?>
                        </h5>

                        <p class="text-white small mb-0">
                            <?= htmlspecialchars($galeri['deskripsi']); ?>
                        </p>

                    </div>

                </div>

            </div>

            <?php endwhile; ?>

        </div>

    </div>

</section>

<!-- =========================================
                TESTIMONI
========================================== -->

<section id="testimoni">

    <div class="container">

        <div class="section-title">

            <span>Testimoni</span>

            <h2>Apa Kata Pelanggan?</h2>

            <p>
                Kepuasan pelanggan merupakan prioritas utama kami.
            </p>

        </div>

        <!-- Tombol Tulis Testimoni (Memicu Modal / Pop Up) -->
        <div class="text-center mb-5">

            <?php if(isset($_SESSION['login'])){ ?>

                <!-- Tombol trigger modal untuk user yang sudah login -->
                <button type="button" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTestimoni">
                    <i class="bi bi-pencil-square me-1"></i> Tulis Testimoni
                </button>

            <?php }else{ ?>

                <!-- Tombol untuk user yang belum login -->
                <button class="btn btn-primary px-4 py-2 rounded-pill shadow-sm" onclick="harusLogin()">
                    <i class="bi bi-pencil-square me-1"></i> Tulis Testimoni
                </button>

            <?php } ?>

        </div>

        <div class="row g-4">

        <?php
        $data = mysqli_query($koneksi,"
            SELECT *
            FROM testimoni
            WHERE status='Tampil'
            ORDER BY id_testimoni DESC
            LIMIT 6
        ");

        if(mysqli_num_rows($data)>0){
            while($d=mysqli_fetch_assoc($data)){
        ?>

            <div class="col-lg-4 col-md-6">

                <div class="testimonial-card h-100 p-4 border-0 shadow-sm rounded-4 bg-white">

                    <div class="d-flex align-items-center mb-3">
                        <img src="uploads/foto/<?= !empty($d['foto']) ? $d['foto'] : 'default.png'; ?>"
                             class="img-fluid rounded-circle shadow-sm"
                             style="width:60px;height:60px;object-fit:cover;">
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold fs-6">
                                <?= htmlspecialchars($d['nama']); ?>
                            </h5>
                            <small class="text-muted">
                                <?= htmlspecialchars($d['alamat']); ?>
                            </small>
                        </div>
                    </div>

                    <div class="testimonial-stars mb-2 text-warning">
                        <?php
                        for($i=1;$i<=5;$i++){
                            if($i<=$d['rating']){
                                echo '<i class="bi bi-star-fill"></i>';
                            }else{
                                echo '<i class="bi bi-star"></i>';
                            }
                        }
                        ?>
                    </div>

                    <p class="text-secondary small mb-0">
                        "<?= htmlspecialchars($d['isi_testimoni']); ?>"
                    </p>

                </div>

            </div>

        <?php
            }
        }else{
        ?>

            <div class="col-12">
                <div class="alert alert-light text-center border py-4 text-muted rounded-4">
                    Belum ada testimoni pelanggan.
                </div>
            </div>

        <?php } ?>

        </div>

    </div>

</section>
<!-- =========================================
      MODAL POP UP FORM TULIS TESTIMONI
========================================== -->
<?php if(isset($_SESSION['login'])): ?>
<div class="modal fade" id="modalTestimoni" tabindex="-1" aria-labelledby="modalTestimoniLabel" aria-hidden="thirrue">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold" id="modalTestimoniLabel">
                    <i class="bi bi-chat-heart-fill me-2"></i> Tulis Testimoni Anda
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- Form Mengarah ke Script Proses Simpan -->
            <form action="user/proses_tambah_testimoni.php" method="POST">
                <div class="modal-body p-4">
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-secondary">Rating Pelayanan</label>
                        <select name="rating" class="form-select rounded-3 shadow-sm" required>
                            <option value="5">⭐⭐⭐⭐⭐ (5/5 - Sangat Memuaskan)</option>
                            <option value="4">⭐⭐⭐⭐ (4/5 - Memuaskan)</option>
                            <option value="3">⭐⭐⭐ (3/5 - Cukup)</option>
                            <option value="2">⭐⭐ (2/5 - Kurang)</option>
                            <option value="1">⭐ (1/5 - Sangat Kurang)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small text-secondary">Komentar / Ulasan</label>
                        <textarea name="isi_testimoni" class="form-control rounded-3 shadow-sm" rows="4" placeholder="Ceritakan pengalaman Anda menggunakan layanan kami..." required></textarea>
                    </div>

                    <div class="form-text text-muted small">
                        * Testimoni akan direview terlebih dahulu oleh admin sebelum tampil di halaman utama.
                    </div>

                </div>
                <div class="modal-footer bg-light rounded-bottom-4 px-4 py-3">
                    <button type="button" class="btn btn-light border px-3 rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="kirim" class="btn btn-primary px-4 rounded-3 shadow-sm">Kirim Testimoni</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- =========================================
                FAQ
========================================== -->

<section id="faq">

    <div class="container">

        <div class="section-title">

            <span>FAQ</span>

            <h2>Pertanyaan yang Sering Ditanyakan</h2>

            <p>
                Beberapa pertanyaan yang sering diajukan pelanggan
                mengenai layanan Rumah AC Harda Tehnik Mandiri.
            </p>

        </div>

        <div class="accordion" id="faqAccordion">

            <!-- FAQ 1 -->
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq1">

                        Berapa biaya service AC?

                    </button>

                </h2>

                <div id="faq1"
                    class="accordion-collapse collapse show"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Biaya service disesuaikan dengan jenis layanan
                        dan kondisi AC. Silakan hubungi admin untuk
                        mendapatkan estimasi harga.

                    </div>

                </div>

            </div>

            <!-- FAQ 2 -->
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq2">

                        Apakah tersedia garansi?

                    </button>

                </h2>

                <div id="faq2"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Ya. Kami memberikan garansi sesuai dengan jenis
                        pekerjaan yang dilakukan teknisi.

                    </div>

                </div>

            </div>

            <!-- FAQ 3 -->
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq3">

                        Area mana saja yang dilayani?

                    </button>

                </h2>

                <div id="faq3"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Kami melayani Bandar Lampung dan wilayah
                        sekitarnya.

                    </div>

                </div>

            </div>

            <!-- FAQ 4 -->
            <div class="accordion-item">

                <h2 class="accordion-header">

                    <button class="accordion-button collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#faq4">

                        Berapa lama proses pengerjaan service AC?

                    </button>

                </h2>

                <div id="faq4"
                    class="accordion-collapse collapse"
                    data-bs-parent="#faqAccordion">

                    <div class="accordion-body">

                        Lama pengerjaan tergantung jenis layanan dan kondisi AC.
                        Untuk cuci AC umumnya membutuhkan waktu sekitar 30–60 menit,
                        sedangkan perbaikan atau penggantian komponen dapat memerlukan
                        waktu lebih lama sesuai tingkat kerusakannya.

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<!-- =========================================
            CTA BOOKING
========================================== -->

<section>

    <div class="container">

        <div class="booking-box">

            <h2>

                Butuh Service AC Sekarang?

            </h2>

            <p>

                Booking layanan secara online,
                teknisi kami siap datang ke lokasi Anda.

            </p>

           <?php if($isLogin): ?>

                <a href="user/booking.php"
                class="btn btn-success btn-lg">
                Booking Sekarang
                </a>

                <?php else: ?>

                <button type="button"
                        class="btn btn-light btn-lg"
                        onclick="harusLogin()">
                    Booking Sekarang
                </button>

                <?php endif; ?>

        </div>

    </div>

</section>

<!-- =========================================
            KONTAK
========================================== -->

<section id="kontak">

    <div class="container">

        <div class="section-title text-white">

            <span class="text-white">

                Kontak

            </span>

            <h2 class="text-white">

                Hubungi Kami

            </h2>

        </div>

        <div class="row g-4">

            <div class="col-lg-5">

                <div class="contact-box">

                    <h4>Informasi Kontak</h4>

                    <div class="contact-info">

                        <i class="bi bi-geo-alt-fill"></i>

                        <div>

                            <h6>Alamat</h6>

                            <p>
                                Jakarta Barat,
                                Jakarta
                            </p>

                        </div>

                    </div>

                    <div class="contact-info">

                        <i class="bi bi-telephone-fill"></i>

                        <div>

                            <h6>Telepon</h6>

                            <p>0856-7024-777</p>

                        </div>

                    </div>

                    <div class="contact-info">

                        <i class="bi bi-envelope-fill"></i>

                        <div>

                            <h6>Email</h6>

                            <p>khalisa232323@gmail.com</p>

                        </div>

                    </div>

                    <div class="contact-info">

                        <i class="bi bi-clock-fill"></i>

                        <div>

                            <h6>Jam Operasional</h6>

                            <p>

                                Senin - Sabtu
                                <br>

                                08.00 - 17.00 WIB

                            </p>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-7">

                <div class="contact-box">

                    <iframe
                        src="https://maps.google.com/maps?q=-6.1028467,106.7087226&z=17&output=embed"
                        width="100%"
                        height="420"
                        style="border:0; border-radius:15px;"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>

                </div>

            </div>

        </div>

    </div>

</section>

<?php include 'includes/footer.php'; ?>