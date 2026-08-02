<!-- =========================
     FOOTER
========================== -->
<footer class="footer">

    <div class="container">

        <div class="row gy-4">

            <!-- Tentang -->
            <div class="col-lg-4">

                <h4 class="footer-logo">
                    CV. HARDA TEHNIK MANDIRI
                </h4>

                <p>
                    CV. Harda Tehnik Mandiri merupakan perusahaan yang bergerak
                    di bidang jasa service AC, perawatan AC, perbaikan AC,
                    bongkar pasang AC, isi freon, serta penjualan AC baru
                    dan bekas dengan teknisi profesional.
                </p>

            </div>

            <!-- Menu -->
            <div class="col-lg-2 col-md-6">

                <h5 class="footer-title">
                    Menu
                </h5>

                <ul class="list-unstyled">

                    <li>
                        <a href="index.php">Beranda</a>
                    </li>

                    <li>
                        <a href="#layanan">Layanan</a>
                    </li>

                    <li>
                        <a href="#produk">Produk</a>
                    </li>

                    <li>
                        <a href="#tentang">Tentang</a>
                    </li>

                    <li>
                        <a href="#kontak">Kontak</a>
                    </li>

                </ul>

            </div>

            <!-- Layanan -->
            <div class="col-lg-3 col-md-6">

                <h5 class="footer-title">
                    Layanan Kami
                </h5>

                <ul class="list-unstyled">

                    <li>Service AC</li>

                    <li>Perbaikan AC</li>

                    <li>Cuci AC</li>

                    <li>Isi Freon</li>

                    <li>Bongkar Pasang AC</li>

                    <li>Jual Beli AC</li>

                </ul>

            </div>

            <!-- Kontak -->
            <div class="col-lg-3">

                <h5 class="footer-title">
                    Hubungi Kami
                </h5>

                <p>

                    <i class="bi bi-geo-alt-fill"></i>

                    Jakarta Barat, Jakarta

                </p>

                <p>

                    <i class="bi bi-telephone-fill"></i>

                    +6285-6702-4777

                </p>

                <p>

                    <i class="bi bi-envelope-fill"></i>

                    khalisa232323@gmail.com

                </p>

                <div class="mt-3">

                    <a href="#" class="me-3 text-white">

                        <i class="bi bi-facebook fs-4"></i>

                    </a>

                    <a href="#" class="me-3 text-white">

                        <i class="bi bi-instagram fs-4"></i>

                    </a>

                    <a href="#" class="me-3 text-white">

                        <i class="bi bi-whatsapp fs-4"></i>

                    </a>

                </div>

            </div>

        </div>

        <hr class="my-5 text-secondary">

        <div class="row align-items-center">

            <div class="col-md-6">

                <p class="mb-0">

                    © <?= date('Y'); ?>

                    CV. HARDA TEHNIK MANDIRI.

                    All Rights Reserved.

                </p>

            </div>

            <div class="col-md-6 text-md-end">

                <a href="#" class="text-white text-decoration-none me-3">

                    Privacy Policy

                </a>

                <a href="#" class="text-white text-decoration-none">

                    Terms & Conditions

                </a>

            </div>

        </div>

    </div>

</footer>

<!-- Back To Top -->

<a href="#" class="back-to-top">

    <i class="bi bi-arrow-up"></i>

</a>

<!-- Floating WhatsApp -->

<a href="https://wa.me/628567024777"
   class="whatsapp"
   target="_blank">

    <i class="bi bi-whatsapp"></i>

</a>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>

AOS.init({

    duration: 800,

    once: true

});

</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function harusLogin(){

    Swal.fire({

        icon:'warning',

        title:'Login Diperlukan',

        text:'Silakan login terlebih dahulu untuk menggunakan fitur ini.',

        confirmButtonText:'Login Sekarang',

        showCancelButton:true,

        cancelButtonText:'Batal',

        confirmButtonColor:'#0d6efd',

        cancelButtonColor:'#6c757d'

    }).then((result)=>{

        if(result.isConfirmed){

            window.location.href='user/login.php';

        }

    });

}

</script>

<!-- Javascript -->
<script src="<?= $base_url ?>assets/js/script.js"></script>


</body>
</html>