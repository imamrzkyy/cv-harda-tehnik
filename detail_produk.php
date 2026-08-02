<?php
session_start();

include "config/koneksi.php";
include "includes/header.php";
include "includes/navbar.php";

if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id = (int)$_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT *
    FROM produk
    WHERE id_produk = '$id'
");

if (mysqli_num_rows($query) == 0) {
    echo "
    <div class='container py-5 mt-5'>
        <div class='alert alert-danger text-center'>
            Produk tidak ditemukan.
        </div>
    </div>
    ";
    include "includes/footer.php";
    exit;
}

$data = mysqli_fetch_assoc($query);
?>

<section class="py-5 mt-5">

    <div class="container">

        <div class="row g-5">

            <div class="col-lg-5">

                <div class="card border-0 shadow-sm">

                    <img
                        src="uploads/produk/<?= $data['gambar']; ?>"
                        class="img-fluid rounded"
                        alt="<?= $data['nama_produk']; ?>">

                </div>

            </div>

            <div class="col-lg-7">

                <span class="badge bg-primary mb-3">

                    <?= $data['kondisi']; ?>

                </span>

                <h2 class="fw-bold">

                    <?= $data['nama_produk']; ?>

                </h2>

                <hr>

                <table class="table">

                    <tr>

                        <th width="180">Merk</th>

                        <td><?= $data['merk']; ?></td>

                    </tr>

                    <tr>

                        <th>PK AC</th>

                        <td><?= $data['pk_ac']; ?></td>

                    </tr>

                    <tr>

                        <th>Kondisi</th>

                        <td><?= $data['kondisi']; ?></td>

                    </tr>

                    <tr>

                        <th>Harga</th>

                        <td class="text-primary fw-bold fs-4">

                            Rp <?= number_format($data['harga'],0,',','.'); ?>

                        </td>

                    </tr>

                    <tr>

                        <th>Stok</th>

                        <td>

                            <?php if($data['stok']>0){ ?>

                                <span class="badge bg-success">

                                    <?= $data['stok']; ?> Unit

                                </span>

                            <?php }else{ ?>

                                <span class="badge bg-danger">

                                    Habis

                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                    <tr>

                        <th>Status</th>

                        <td>

                            <?php if($data['status']=="Tersedia"){ ?>

                                <span class="badge bg-success">

                                    Tersedia

                                </span>

                            <?php }else{ ?>

                                <span class="badge bg-danger">

                                    Habis

                                </span>

                            <?php } ?>

                        </td>

                    </tr>

                </table>

                <div class="mt-4">

                    <h5>Deskripsi Produk</h5>

                    <p>

                        <?= nl2br($data['deskripsi']); ?>

                    </p>

                </div>

                <?php

                $pesan = "
                        Halo Admin CV. HARDA TEHNIK MANDIRI.

                        Saya tertarik dengan produk berikut:

                         Produk : {$data['nama_produk']}
                         Merk : {$data['merk']}
                         PK AC : {$data['pk_ac']}
                         Harga : Rp ".number_format($data['harga'],0,',','.')."

                        Mohon informasi mengenai:
                        - Ketersediaan stok
                        - Garansi
                        - Biaya pemasangan

                        Terima kasih.
                        ";

                ?>

                <div class="d-flex gap-2 mt-4">

                    <a href="produk.php"
                       class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        Kembali

                    </a>

                    <a href="https://wa.me/628567024777?text=<?= urlencode($pesan); ?>"target="_blank" class="btn btn-success"><i class="bi bi-whatsapp"></i> Tanya Produk
                    </a>

                </div>

            </div>

        </div>

        <hr class="my-5">

        <div class="text-center">

            <h3 class="fw-bold">

                Kenapa Membeli di CV. HARDA TEHNIK MANDIRI?

            </h3>

            <div class="row mt-4">

                <div class="col-md-4">

                    <i class="bi bi-shield-check fs-1 text-primary"></i>

                    <h5 class="mt-3">Produk Bergaransi</h5>

                    <p>
                        Seluruh produk mendapatkan garansi sesuai ketentuan.
                    </p>

                </div>

                <div class="col-md-4">

                    <i class="bi bi-tools fs-1 text-primary"></i>

                    <h5 class="mt-3">Pemasangan Profesional</h5>

                    <p>
                        Pemasangan dilakukan langsung oleh teknisi berpengalaman.
                    </p>

                </div>

                <div class="col-md-4">

                    <i class="bi bi-headset fs-1 text-primary"></i>

                    <h5 class="mt-3">Layanan Konsultasi</h5>

                    <p>
                        Gratis konsultasi sebelum melakukan pembelian.
                    </p>

                </div>

            </div>

        </div>

    </div>

</section>

<?php include "includes/footer.php"; ?>