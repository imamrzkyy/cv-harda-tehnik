<?php
session_start();

include "config/koneksi.php";
include "includes/header.php";
include "includes/navbar.php";

/* ===========================
   FILTER
=========================== */

$id_kategori = isset($_GET['kategori']) ? (int) $_GET['kategori'] : 0;
$merk        = isset($_GET['merk']) ? mysqli_real_escape_string($koneksi, $_GET['merk']) : '';
$pk_ac       = isset($_GET['pk']) ? mysqli_real_escape_string($koneksi, $_GET['pk']) : '';

/* ===========================
   DATA FILTER
=========================== */

// Data kategori
$dataKategori = mysqli_query($koneksi, "
    SELECT *
    FROM kategori_produk
    ORDER BY nama_kategori ASC
");

// Data merk
$dataMerk = mysqli_query($koneksi, "
    SELECT DISTINCT merk
    FROM produk
    WHERE merk IS NOT NULL
    AND merk <> ''
    ORDER BY merk ASC
");

// Data PK
$dataPk = mysqli_query($koneksi, "
    SELECT DISTINCT pk_ac
    FROM produk
    WHERE pk_ac IS NOT NULL
    AND pk_ac <> ''
    ORDER BY pk_ac ASC
");

/* ===========================
   QUERY PRODUK
=========================== */

$sql = "
SELECT
    produk.*,
    kategori_produk.nama_kategori
FROM produk
LEFT JOIN kategori_produk
ON kategori_produk.id_kategori = produk.id_kategori
WHERE produk.status='Tersedia'
";

if ($id_kategori > 0) {
    $sql .= " AND produk.id_kategori='$id_kategori'";
}

if ($merk != '') {
    $sql .= " AND produk.merk='$merk'";
}

if ($pk_ac != '') {
    $sql .= " AND produk.pk_ac='$pk_ac'";
}

$sql .= " ORDER BY produk.id_produk DESC";

$query = mysqli_query($koneksi, $sql);
?>

<section class="py-5 mt-5">

    <div class="container">

        <div class="text-center mb-4">

            <h2 class="fw-bold">
                Produk AC
            </h2>

            <p class="text-muted">
                Kami menyediakan berbagai produk AC baru maupun bekas dengan kualitas terbaik.
            </p>

        </div>

        <!-- FILTER -->

        <form method="GET" class="row g-3 mb-5">

            <div class="col-lg-4">

                <label class="form-label fw-semibold">
                    Kategori
                </label>

                <select name="kategori" class="form-select">

                    <option value="">
                        Semua Kategori
                    </option>

                    <?php while($k = mysqli_fetch_assoc($dataKategori)){ ?>

                        <option
                            value="<?= $k['id_kategori']; ?>"
                            <?= ($id_kategori == $k['id_kategori']) ? 'selected' : ''; ?>>

                            <?= $k['nama_kategori']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="col-lg-3">

                <label class="form-label fw-semibold">
                    Merk
                </label>

                <select name="merk" class="form-select">

                    <option value="">
                        Semua Merk
                    </option>

                    <?php while($m = mysqli_fetch_assoc($dataMerk)){ ?>

                        <option
                            value="<?= $m['merk']; ?>"
                            <?= ($merk == $m['merk']) ? 'selected' : ''; ?>>

                            <?= $m['merk']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="col-lg-3">

                <label class="form-label fw-semibold">
                    PK AC
                </label>

                <select name="pk" class="form-select">

                    <option value="">
                        Semua PK
                    </option>

                    <?php while($p = mysqli_fetch_assoc($dataPk)){ ?>

                        <option
                            value="<?= $p['pk_ac']; ?>"
                            <?= ($pk_ac == $p['pk_ac']) ? 'selected' : ''; ?>>

                            <?= $p['pk_ac']; ?>

                        </option>

                    <?php } ?>

                </select>

            </div>

            <div class="col-lg-2 d-flex align-items-end">

                <button type="submit" class="btn btn-primary w-100">

                    <i class="bi bi-funnel-fill"></i>
                    Filter

                </button>

            </div>

        </form>

       <!-- DAFTAR PRODUK -->

<div class="row g-4">

<?php if (mysqli_num_rows($query) > 0) { ?>

    <?php while ($row = mysqli_fetch_assoc($query)) { ?>

        <div class="col-lg-4 col-md-6">

            <div class="card border-0 shadow-sm h-100">

                <!-- Gambar Produk -->
                <img
                    src="uploads/produk/<?= $row['gambar']; ?>"
                    class="card-img-top"
                    alt="<?= $row['nama_produk']; ?>"
                    style="height:260px; object-fit:cover;">

                <div class="card-body d-flex flex-column">

                    <!-- Badge -->
                    <div class="mb-3">

                        <span class="badge bg-primary">
                            <?= $row['nama_kategori']; ?>
                        </span>

                        <?php if ($row['kondisi'] == "Baru") { ?>

                            <span class="badge bg-success">
                                Baru
                            </span>

                        <?php } else { ?>

                            <span class="badge bg-warning text-dark">
                                Bekas
                            </span>

                        <?php } ?>

                    </div>

                    <h5 class="fw-bold mb-3">
                        <?= $row['nama_produk']; ?>
                    </h5>

                    <p class="mb-2">
                        <strong>Merk :</strong>
                        <?= $row['merk']; ?>
                    </p>

                    <p class="mb-2">
                        <strong>PK AC :</strong>
                        <?= $row['pk_ac']; ?>
                    </p>

                    <p class="mb-2">
                        <strong>Stok :</strong>
                        <?= $row['stok']; ?>
                    </p>

                    <h4 class="text-primary fw-bold mt-2 mb-4">
                        Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                    </h4>

                    <div class="mt-auto">

                        <a href="detail_produk.php?id=<?= $row['id_produk']; ?>"
                           class="btn btn-primary w-100">

                            <i class="bi bi-eye"></i>
                            Lihat Detail

                        </a>

                    </div>

                </div>

            </div>

        </div>

    <?php } ?>

<?php } else { ?>

    <div class="col-12">

        <div class="alert alert-warning text-center">

            <i class="bi bi-exclamation-circle"></i>

            Produk tidak ditemukan.

        </div>

    </div>

<?php } ?>

</div>

    </div>

</section>

<?php include "includes/footer.php"; ?>