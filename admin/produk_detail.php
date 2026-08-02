<?php

include "../includes/auth.php";
include "../config/koneksi.php";

if(!isset($_GET['id'])){

    exit("Data tidak ditemukan.");

}

$id = (int)$_GET['id'];

$query = mysqli_query($koneksi,"

    SELECT
        p.*,
        k.nama_kategori

    FROM produk p

    LEFT JOIN kategori_produk k
    ON p.id_kategori = k.id_kategori

    WHERE p.id_produk='$id'

    LIMIT 1

");

if(mysqli_num_rows($query)==0){

    exit("Produk tidak ditemukan.");

}

$data = mysqli_fetch_assoc($query);

/* ===========================
   GAMBAR
=========================== */

if(
    !empty($data['gambar']) &&
    file_exists("../uploads/produk/".$data['gambar'])
){

    $gambar = "../uploads/produk/".$data['gambar'];

}else{

    $gambar = "../assets/images/no-image.png";

}

?>
<div class="container-fluid">

    <div class="row g-4">

        <!-- FOTO -->

        <div class="col-lg-4">

            <div class="text-center">

                <img
                    src="<?= $gambar; ?>"
                    class="img-fluid rounded shadow-sm border"
                    style="
                        width:100%;
                        max-height:350px;
                        object-fit:contain;
                    ">

            </div>

        </div>

        <!-- INFORMASI -->

        <div class="col-lg-8">

            <table class="table table-borderless">

                <tr>

                    <th width="180">

                        Nama Produk

                    </th>

                    <td>

                        <?= htmlspecialchars($data['nama_produk']); ?>

                    </td>

                </tr>

                <tr>

                    <th>

                        Kategori

                    </th>

                    <td>

                        <?= htmlspecialchars($data['nama_kategori']); ?>

                    </td>

                </tr>

                <tr>

                    <th>

                        Merk

                    </th>

                    <td>

                        <?= htmlspecialchars($data['merk']); ?>

                    </td>

                </tr>

                <tr>

                    <th>

                        PK AC

                    </th>

                    <td>

                        <?= htmlspecialchars($data['pk_ac']); ?>

                    </td>

                </tr>

                <tr>

                    <th>

                        Kondisi

                    </th>

                    <td>

                        <?php if($data['kondisi']=="Baru"){ ?>

                            <span class="badge bg-success">

                                Baru

                            </span>

                        <?php }else{ ?>

                            <span class="badge bg-warning text-dark">

                                Bekas

                            </span>

                        <?php } ?>

                    </td>

                </tr>

                <tr>

                    <th>

                        Harga

                    </th>

                    <td class="fw-bold text-primary">

                        Rp <?= number_format($data['harga'],0,',','.'); ?>

                    </td>

                </tr>

                <tr>

                    <th>

                        Stok

                    </th>

                    <td>

                        <?= $data['stok']; ?> Unit

                    </td>

                </tr>

                <tr>

                    <th>

                        Status

                    </th>

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

        </div>

    </div>

    <hr>

    <h5 class="fw-bold">

        Deskripsi Produk

    </h5>

    <div class="border rounded p-3 bg-light">

        <?= nl2br(htmlspecialchars($data['deskripsi'])); ?>

    </div>

    <div class="text-end mt-4">

        <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">

            <i class="bi bi-x-circle"></i>

            Tutup

        </button>

    </div>

</div>