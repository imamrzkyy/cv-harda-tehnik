<?php
include "../includes/auth.php";
include "../config/koneksi.php";


/* ===========================================
   HAPUS PRODUK
=========================================== */

if (isset($_GET['hapus'])) {

    $id = (int) $_GET['hapus'];

    $cek = mysqli_query($koneksi, "
        SELECT gambar
        FROM produk
        WHERE id_produk = '$id'
        LIMIT 1
    ");

    if(mysqli_num_rows($cek)>0){

        $data = mysqli_fetch_assoc($cek);

        if(
            !empty($data['gambar']) &&
            file_exists("../uploads/produk/".$data['gambar'])
        ){
            unlink("../uploads/produk/".$data['gambar']);
        }

        mysqli_query($koneksi,"
            DELETE FROM produk
            WHERE id_produk='$id'
        ");

        header("Location: produk.php?success=hapus");
        exit;
    }
}

$nama = $_SESSION['nama_admin'];
$role = $_SESSION['role_admin'];

include "header.php";
include "sidebar.php";
/* ===========================================
   SEARCH
=========================================== */

$keyword = "";

if(isset($_GET['keyword'])){

    $keyword = trim($_GET['keyword']);

}

/* ===========================================
   FILTER KATEGORI
=========================================== */

$kategori = 0;

if(isset($_GET['kategori'])){

    $kategori = (int)$_GET['kategori'];

}

/* ===========================================
   PAGINATION
=========================================== */

$batas = 10;

$halaman = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;

if($halaman < 1){

    $halaman = 1;

}

$mulai = ($halaman - 1) * $batas;

/* ===========================================
   WHERE
=========================================== */

$where = "WHERE 1=1";

if($keyword != ""){

    $keyword = mysqli_real_escape_string($koneksi,$keyword);

    $where .= " AND (
        p.nama_produk LIKE '%$keyword%'
        OR p.merk LIKE '%$keyword%'
    )";

}

if($kategori != 0){

    $where .= " AND p.id_kategori='$kategori'";

}

/* ===========================================
   TOTAL DATA
=========================================== */

$totalData = mysqli_fetch_assoc(mysqli_query($koneksi,"
    SELECT COUNT(*) AS total
    FROM produk p
    $where
"));

$total = $totalData['total'];

$totalHalaman = ceil($total / $batas);

/* ===========================================
   DATA PRODUK
=========================================== */

$query = mysqli_query($koneksi,"
    SELECT
        p.*,
        k.nama_kategori
    FROM produk p
    LEFT JOIN kategori_produk k
        ON p.id_kategori = k.id_kategori
    $where
    ORDER BY p.id_produk DESC
    LIMIT $mulai,$batas
");

/* ===========================================
   DATA KATEGORI
=========================================== */

$queryKategori = mysqli_query($koneksi,"
    SELECT *
    FROM kategori_produk
    ORDER BY nama_kategori ASC
");

?>
<div class="content">

    <div class="container-fluid">

        <!-- ===========================
             JUDUL HALAMAN
        ============================ -->

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

            <div>

                <h2 class="fw-bold text-primary mb-1">

                    <i class="bi bi-box-seam"></i>

                    Data Produk

                </h2>

                <p class="text-muted mb-0">

                    Kelola seluruh data produk CV. Harda Tehnik Mandiri

                </p>

            </div>

            <a
                href="produk_tambah.php"
                class="btn btn-primary mt-3 mt-md-0">

                <i class="bi bi-plus-circle"></i>

                Tambah Produk

            </a>

        </div>

        <!-- ===========================
             FILTER
        ============================ -->

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form method="GET">

                    <div class="row g-3">

                        <!-- Search -->

                        <div class="col-lg-5">

                            <label class="form-label fw-semibold">

                                Cari Produk

                            </label>

                            <input
                                type="text"
                                name="keyword"
                                class="form-control"
                                placeholder="Cari nama produk atau merk..."
                                value="<?= htmlspecialchars($keyword); ?>">

                        </div>

                        <!-- Filter -->

                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">

                                Kategori

                            </label>

                            <select
                                name="kategori"
                                class="form-select">

                                <option value="0">

                                    Semua Kategori

                                </option>

                                <?php

                                while($kat = mysqli_fetch_assoc($queryKategori)){

                                ?>

                                    <option
                                        value="<?= $kat['id_kategori']; ?>"
                                        <?= ($kategori == $kat['id_kategori']) ? "selected" : ""; ?>>

                                        <?= htmlspecialchars($kat['nama_kategori']); ?>

                                    </option>

                                <?php } ?>

                            </select>

                        </div>

                        <!-- Tombol -->

                        <div class="col-lg-4">

                            <label class="form-label d-block">

                                &nbsp;

                            </label>

                            <div class="d-flex gap-2">

                                <button
                                    class="btn btn-primary">

                                    <i class="bi bi-search"></i>

                                    Cari

                                </button>

                                <a
                                    href="produk.php"
                                    class="btn btn-secondary">

                                    <i class="bi bi-arrow-clockwise"></i>

                                    Reset

                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>
                <!-- ===========================
             TABEL PRODUK
        ============================ -->

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="mb-0 fw-bold">

                        <i class="bi bi-table"></i>

                        Daftar Produk

                    </h5>

                    <span class="badge bg-primary">

                        Total : <?= number_format($total); ?> Produk

                    </span>

                </div>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr class="text-center">

                                <th width="60">No</th>

                                <th width="90">Foto</th>

                                <th>Produk</th>

                                <th>Kategori</th>

                                <th>Harga</th>

                                <th>Stok</th>

                                <th>Status</th>

                                <th width="180">Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php

                        if(mysqli_num_rows($query) > 0){

                            $no = $mulai + 1;

                            while($row = mysqli_fetch_assoc($query)){

                        ?>

                            <tr>

                                <td class="text-center">

                                    <?= $no++; ?>

                                </td>

                                <!-- FOTO -->

                                <td class="text-center">

                                    <?php

                                    if(!empty($row['gambar']) && file_exists("../uploads/produk/".$row['gambar'])){

                                    ?>

                                        <img
                                            src="../uploads/produk/<?= htmlspecialchars($row['gambar']); ?>"
                                            width="70"
                                            height="70"
                                            style="
                                                object-fit:cover;
                                                border-radius:10px;
                                            ">

                                    <?php

                                    }else{

                                    ?>

                                        <img
                                            src="../assets/images/no-image.png"
                                            width="70"
                                            height="70"
                                            style="
                                                object-fit:cover;
                                                border-radius:10px;
                                            ">

                                    <?php } ?>

                                </td>

                                <!-- PRODUK -->

                                <td>

                                    <strong>

                                        <?= htmlspecialchars($row['nama_produk']); ?>

                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        <?= htmlspecialchars($row['merk']); ?>

                                    </small>

                                    <br>

                                    <span class="badge bg-secondary mt-1">

                                        <?= htmlspecialchars($row['pk_ac']); ?>

                                    </span>

                                </td>

                                <!-- KATEGORI -->

                                <td>

                                    <?= htmlspecialchars($row['nama_kategori'] ?? "-"); ?>

                                </td>

                                <!-- HARGA -->

                                <td>

                                    <strong class="text-success">

                                        Rp <?= number_format($row['harga'],0,",","."); ?>

                                    </strong>

                                </td>

                                <!-- STOK -->

                                <td class="text-center">

                                    <?php

                                    if($row['stok'] <= 5){

                                        echo '<span class="badge bg-danger">'.$row['stok'].' Unit</span>';

                                    }elseif($row['stok'] <= 10){

                                        echo '<span class="badge bg-warning text-dark">'.$row['stok'].' Unit</span>';

                                    }else{

                                        echo '<span class="badge bg-success">'.$row['stok'].' Unit</span>';

                                    }

                                    ?>

                                </td>

                                <!-- STATUS -->

                                <td class="text-center">

                                    <?php

                                    if($row['status']=="Tersedia"){

                                        echo '<span class="badge bg-success">Tersedia</span>';

                                    }else{

                                        echo '<span class="badge bg-danger">Habis</span>';

                                    }

                                    ?>

                                </td>

                                <!-- AKSI -->

                                <td class="text-center">

                                    <div class="btn-group">

                                       <button
                                            type="button"
                                            class="btn btn-info btn-sm text-white btn-detail"
                                            data-id="<?= $row['id_produk']; ?>">

                                            <i class="bi bi-eye"></i>

                                        </button>

                                       <button
                                            type="button"
                                            class="btn btn-warning btn-sm btn-edit"
                                            data-id="<?= $row['id_produk']; ?>"
                                            title="Edit">

                                            <i class="bi bi-pencil-square"></i>

                                        </button>

                                        <a
                                            href="produk.php?hapus=<?= $row['id_produk']; ?>"
                                            class="btn btn-danger btn-sm btn-hapus"
                                            data-nama="<?= htmlspecialchars($row['nama_produk']); ?>"
                                            title="Hapus">

                                            <i class="bi bi-trash"></i>

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php

                            }

                        }else{

                        ?>

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5 text-muted">

                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>

                                    Belum ada data produk.

                                </td>

                            </tr>

                        <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
                <!-- ===========================
             PAGINATION
        ============================ -->

        <?php if($totalHalaman > 1){ ?>

        <div class="d-flex justify-content-between align-items-center flex-wrap mt-4">

            <div class="text-muted mb-2">

                Menampilkan

                <strong>

                    <?= ($mulai + 1); ?>

                </strong>

                -

                <strong>

                    <?= min($mulai + $batas, $total); ?>

                </strong>

                dari

                <strong>

                    <?= $total; ?>

                </strong>

                data produk

            </div>

            <nav>

                <ul class="pagination mb-0">

                    <!-- Previous -->

                    <?php if($halaman > 1){ ?>

                        <li class="page-item">

                            <a
                                class="page-link"
                                href="?hal=<?= $halaman-1; ?>&keyword=<?= urlencode($keyword); ?>&kategori=<?= $kategori; ?>">

                                <i class="bi bi-chevron-left"></i>

                            </a>

                        </li>

                    <?php } ?>

                    <!-- Nomor Halaman -->

                    <?php

                    $start = max(1, $halaman - 2);
                    $end   = min($totalHalaman, $halaman + 2);

                    for($i=$start; $i<=$end; $i++){

                    ?>

                        <li class="page-item <?= ($i==$halaman) ? 'active' : ''; ?>">

                            <a
                                class="page-link"
                                href="?hal=<?= $i; ?>&keyword=<?= urlencode($keyword); ?>&kategori=<?= $kategori; ?>">

                                <?= $i; ?>

                            </a>

                        </li>

                    <?php } ?>

                    <!-- Next -->

                    <?php if($halaman < $totalHalaman){ ?>

                        <li class="page-item">

                            <a
                                class="page-link"
                                href="?hal=<?= $halaman+1; ?>&keyword=<?= urlencode($keyword); ?>&kategori=<?= $kategori; ?>">

                                <i class="bi bi-chevron-right"></i>

                            </a>

                        </li>

                    <?php } ?>

                </ul>

            </nav>

        </div>

        <?php } ?>

    </div>

</div>
<!-- ===========================
     MODAL DETAIL PRODUK
=========================== -->

<div
    class="modal fade"
    id="modalDetail"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">

                    <i class="bi bi-box-seam"></i>

                    Detail Produk

                </h5>

                <button
                    type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div
                class="modal-body"
                id="detailProduk">

                <div class="text-center py-5">

                    <div class="spinner-border text-primary"></div>

                    <p class="mt-3">

                        Memuat data...

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- ===========================
     MODAL EDIT PRODUK
=========================== -->

<div
    class="modal fade"
    id="modalEdit"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-warning">

                <h5 class="modal-title">

                    <i class="bi bi-pencil-square"></i>

                    Edit Produk

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div
                class="modal-body"
                id="editProduk">

                <div class="text-center py-5">

                    <div class="spinner-border text-warning"></div>

                    <p class="mt-3">

                        Memuat data...

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>
<!-- ===========================
     SWEETALERT HAPUS
============================ -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.querySelectorAll(".btn-hapus").forEach(function(button){

    button.addEventListener("click", function(e){

        e.preventDefault();

        let url = this.href;

        let nama = this.dataset.nama;

        Swal.fire({

            title: "Hapus Produk?",

            html: "Produk <b>"+nama+"</b> akan dihapus permanen.",

            icon: "warning",

            showCancelButton: true,

            confirmButtonColor: "#dc3545",

            cancelButtonColor: "#6c757d",

            confirmButtonText: "Ya, Hapus",

            cancelButtonText: "Batal"

        }).then((result)=>{

            if(result.isConfirmed){

                window.location.href = url;

            }

        });

    });

});

<?php if(isset($_GET['success']) && $_GET['success']=="hapus"){ ?>

Swal.fire({

    icon:"success",

    title:"Berhasil",

    text:"Produk berhasil dihapus.",

    timer:1800,

    showConfirmButton:false

});

<?php } ?>

</script>

<?php include "footer.php"; ?>