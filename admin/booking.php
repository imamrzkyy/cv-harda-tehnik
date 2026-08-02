<?php
include "../includes/auth.php";
include "../config/koneksi.php";

/* =====================================
   FILTER
===================================== */

$keyword = isset($_GET['keyword'])
    ? mysqli_real_escape_string($koneksi, $_GET['keyword'])
    : '';

$status = isset($_GET['status'])
    ? mysqli_real_escape_string($koneksi, $_GET['status'])
    : '';

/* =====================================
   UPDATE STATUS BOOKING
===================================== */

if (isset($_POST['ubah_status'])) {

    $id_booking   = (int) $_POST['id_booking'];
    $statusBaru   = mysqli_real_escape_string($koneksi, $_POST['status']);
    $total_bayar  = str_replace(".", "", $_POST['total_bayar']);

    // ambil harga layanan
    $cek = mysqli_query($koneksi,"
        SELECT layanan.harga
        FROM booking
        JOIN layanan
        ON layanan.id_layanan = booking.id_layanan
        WHERE booking.id_booking='$id_booking'
    ");

    $data = mysqli_fetch_assoc($cek);
    $harga = $data['harga'];

    // kalau status selesai harus lunas
    if($statusBaru=="Selesai" && $total_bayar < $harga){

        echo "
        <script>
            alert('Pembayaran belum lunas!');
            history.back();
        </script>
        ";
        exit;

    }

    $dibayar = (float)$total_bayar;
    $sisa = $harga - $dibayar;

    if($sisa < 0){
        $sisa = 0;
    }

    $status_pembayaran = ($dibayar >= $harga)
        ? "Lunas"
        : "Belum Lunas";

    mysqli_query($koneksi,"
    UPDATE booking
    SET
        total_biaya='$harga',
        dibayar='$dibayar',
        sisa='$sisa',
        status_pembayaran='$status_pembayaran',
        status='$statusBaru'
    WHERE id_booking='$id_booking'
    ");

    echo "
    <script>
        alert('Booking berhasil diperbarui');
        window.location='booking.php';
    </script>
    ";
    exit;
}

/* =====================================
   DATA BOOKING
===================================== */

$sql = "
SELECT
    booking.*,
    user.nama,
    user.email,
    user.no_hp,
    user.alamat,
    layanan.nama_layanan,
    layanan.harga,
    layanan.estimasi
FROM booking
INNER JOIN user
    ON user.id_user = booking.id_user
INNER JOIN layanan
    ON layanan.id_layanan = booking.id_layanan
WHERE 1 = 1
";

if ($keyword != '') {

    $sql .= "
    AND user.nama LIKE '%$keyword%'
    ";
}

if ($status != '') {

    $sql .= "
    AND booking.status = '$status'
    ";
}

$sql .= "
ORDER BY booking.id_booking DESC
";

$query = mysqli_query($koneksi, $sql);

/* =====================================
   HEADER
===================================== */

include "header.php";
include "sidebar.php";
?>

<div class="content">

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="fw-bold text-primary mb-1">

                    <i class="bi bi-calendar-check"></i>

                    Data Booking

                </h2>

                <p class="text-muted mb-0">

                    Kelola seluruh data booking pelanggan.

                </p>

            </div>

        </div>
                <!-- ==========================
             FILTER
        =========================== -->

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form method="GET">

                    <div class="row g-3">

                        <div class="col-lg-5">

                            <label class="form-label fw-semibold">

                                Cari Nama Pelanggan

                            </label>

                            <input
                                type="text"
                                name="keyword"
                                class="form-control"
                                placeholder="Masukkan nama pelanggan..."
                                value="<?= htmlspecialchars($keyword); ?>">

                        </div>

                        <div class="col-lg-3">

                            <label class="form-label fw-semibold">

                                Status Booking

                            </label>

                            <select
                                name="status"
                                class="form-select">

                                <option value="">

                                    Semua Status

                                </option>

                                <option
                                    value="Menunggu"
                                    <?= ($status == "Menunggu") ? "selected" : ""; ?>>

                                    Menunggu

                                </option>

                                <option
                                    value="Diproses"
                                    <?= ($status == "Diproses") ? "selected" : ""; ?>>

                                    Diproses

                                </option>

                                <option
                                    value="Selesai"
                                    <?= ($status == "Selesai") ? "selected" : ""; ?>>

                                    Selesai

                                </option>

                                <option
                                    value="Dibatalkan"
                                    <?= ($status == "Dibatalkan") ? "selected" : ""; ?>>

                                    Dibatalkan

                                </option>

                            </select>

                        </div>

                        <div class="col-lg-4 d-flex align-items-end">

                            <button
                                type="submit"
                                class="btn btn-primary me-2">

                                <i class="bi bi-search"></i>

                                Cari

                            </button>

                            <a
                                href="booking.php"
                                class="btn btn-secondary me-2">

                                <i class="bi bi-arrow-clockwise"></i>

                                Reset

                            </a>

                            <a
                                href="booking.php"
                                class="btn btn-success">

                                <i class="bi bi-arrow-repeat"></i>

                                Refresh

                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

        <!-- ==========================
             TABEL BOOKING
        =========================== -->

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-table"></i>

                    Daftar Booking

                </h5>

            </div>

            <div class="card-body table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Jadwal</th>
                            <th>Status</th>
                            <th width="250">Pembayaran</th>
                            <th width="120">Aksi</th>
                        </tr>
                        </thead>

                    <tbody>

                    <?php

                    $no = 1;

                    if(mysqli_num_rows($query) > 0){

                        while($row = mysqli_fetch_assoc($query)){

                    ?>

                        <tr>

                            <td>

                                <?= $no++; ?>

                            </td>

                            <td>

                                <strong>

                                    <?= htmlspecialchars($row['nama']); ?>

                                </strong>

                                <br>

                                <small class="text-muted">

                                    <?= htmlspecialchars($row['email']); ?>

                                </small>

                            </td>

                            <td>

                                <?= htmlspecialchars($row['nama_layanan']); ?>

                            </td>

                            <td>

                                <?= date('d-m-Y', strtotime($row['tanggal'])); ?>

                                <br>

                                <small class="text-muted">

                                    <?= substr($row['jam'],0,5); ?>

                                </small>

                            </td>

                            <td>

                                <?php

                                if($row['status']=="Menunggu"){

                                    echo '<span class="badge bg-warning text-dark">Menunggu</span>';

                                }elseif($row['status']=="Diproses"){

                                    echo '<span class="badge bg-primary">Diproses</span>';

                                }elseif($row['status']=="Selesai"){

                                    echo '<span class="badge bg-success">Selesai</span>';

                                }else{

                                    echo '<span class="badge bg-danger">Dibatalkan</span>';

                                }

                                ?>

                            </td>
                            <td style="min-width:220px">

                        <div class="small text-muted">Total</div>
                            <strong>
                                Rp <?= number_format($row['total_biaya'],0,',','.'); ?>
                            </strong>

                            <div class="small text-muted mt-2">Dibayar</div>
                            <strong class="text-success">
                                Rp <?= number_format($row['dibayar'],0,',','.'); ?>
                            </strong>

                            <div class="small text-muted mt-2">Sisa</div>
                            <strong class="text-danger">
                                Rp <?= number_format($row['sisa'],0,',','.'); ?>
                            </strong>

                            <div class="mt-2">
                                <?php if($row['status_pembayaran']=="Lunas"){ ?>
                                    <span class="badge bg-success">Lunas</span>
                                <?php }else{ ?>
                                    <span class="badge bg-warning text-dark">Belum Lunas</span>
                                <?php } ?>
                            </div>

                        </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2 flex-nowrap">

                                    <button
                                        type="button"
                                        class="btn btn-info btn-sm text-white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detail<?= $row['id_booking']; ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#edit<?= $row['id_booking']; ?>">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <a
                                        href="booking.php?hapus=<?= $row['id_booking']; ?>"
                                        class="btn btn-danger btn-sm btn-hapus">
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
                                colspan="6"
                                class="text-center text-muted py-4">

                                Belum ada data booking.

                            </td>

                        </tr>

                    <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>
        <?php
mysqli_data_seek($query, 0);

while ($row = mysqli_fetch_assoc($query)) {
?>

<!-- ==================================================
     MODAL DETAIL BOOKING
=================================================== -->

<div class="modal fade"
     id="detail<?= $row['id_booking']; ?>"
     tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-primary text-white">

                <h5 class="modal-title">
                    <i class="bi bi-calendar-check"></i>
                    Detail Booking
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nama Pelanggan</label>
                        <p><?= htmlspecialchars($row['nama']); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Email</label>
                        <p><?= htmlspecialchars($row['email']); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Nomor HP</label>
                        <p><?= htmlspecialchars($row['no_hp']); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Layanan</label>
                        <p><?= htmlspecialchars($row['nama_layanan']); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Harga Layanan</label>
                        <p class="text-primary fw-bold">
                            Rp <?= number_format($row['harga'],0,',','.'); ?>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Estimasi</label>
                        <p><?= htmlspecialchars($row['estimasi']); ?></p>
                    </div>

                    <!-- DATA PEMBAYARAN -->

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Total Biaya</label>
                        <p class="fw-bold text-primary">
                            Rp <?= number_format($row['total_biaya'],0,',','.'); ?>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Sudah Dibayar</label>
                        <p class="fw-bold text-success">
                            Rp <?= number_format($row['dibayar'],0,',','.'); ?>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Sisa Pembayaran</label>
                        <p class="fw-bold text-danger">
                            Rp <?= number_format($row['sisa'],0,',','.'); ?>
                        </p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Status Pembayaran</label>

                        <p>
                            <?php if($row['status_pembayaran']=="Lunas"){ ?>
                                <span class="badge bg-success">Lunas</span>
                            <?php } else { ?>
                                <span class="badge bg-warning text-dark">Belum Lunas</span>
                            <?php } ?>
                        </p>
                    </div>

                    <!-- END PEMBAYARAN -->

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Tanggal</label>
                        <p><?= date('d F Y', strtotime($row['tanggal'])); ?></p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Jam</label>
                        <p><?= substr($row['jam'],0,5); ?></p>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="fw-bold">Alamat</label>
                        <p><?= nl2br(htmlspecialchars($row['alamat'])); ?></p>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="fw-bold">Keluhan</label>

                        <div class="border rounded p-3 bg-light">
                            <?= nl2br(htmlspecialchars($row['keluhan'])); ?>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ==================================================
     MODAL EDIT STATUS
=================================================== -->

<div
    class="modal fade"
    id="edit<?= $row['id_booking']; ?>"
    tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <form method="POST">

                <div class="modal-header bg-warning">

                    <h5 class="modal-title">

                        <i class="bi bi-pencil-square"></i>

                        Ubah Status Booking

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="id_booking"
                        value="<?= $row['id_booking']; ?>">

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Nama Pelanggan

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($row['nama']); ?>"
                            readonly>

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Layanan

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($row['nama_layanan']); ?>"
                            readonly>

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Total Pembayaran

                        </label>

                        <input
                            type="number"
                            name="total_bayar"
                            class="form-control"
                            min="0"
                            value="<?= $row['dibayar']; ?>"
                            placeholder="Masukkan total pembayaran">

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Status Booking

                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required>

                            <option
                                value="Menunggu"
                                <?= ($row['status']=="Menunggu")?'selected':''; ?>>

                                Menunggu

                            </option>

                            <option
                                value="Diproses"
                                <?= ($row['status']=="Diproses")?'selected':''; ?>>

                                Diproses

                            </option>

                            <option
                                value="Selesai"
                                <?= ($row['status']=="Selesai")?'selected':''; ?>>

                                Selesai

                            </option>

                            <option
                                value="Dibatalkan"
                                <?= ($row['status']=="Dibatalkan")?'selected':''; ?>>

                                Dibatalkan

                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="submit"
                        name="ubah_status"
                        class="btn btn-primary">

                        <i class="bi bi-check-circle"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php } ?>
</div>

</div>

<!-- SweetAlert2 -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

/* ===========================
   KONFIRMASI HAPUS
=========================== */

document.querySelectorAll(".btn-hapus").forEach(function(btn){

    btn.addEventListener("click",function(e){

        e.preventDefault();

        let url = this.getAttribute("href");

        Swal.fire({

            title: "Hapus Booking?",

            text: "Data booking akan dihapus permanen.",

            icon: "warning",

            showCancelButton: true,

            confirmButtonColor: "#dc3545",

            cancelButtonColor: "#6c757d",

            confirmButtonText: "Ya, Hapus",

            cancelButtonText: "Batal"

        }).then((result)=>{

            if(result.isConfirmed){

                window.location = url;

            }

        });

    });

});

</script>

<style>

.table td{

    vertical-align:middle;

}

.badge{

    padding:8px 12px;

    font-size:13px;

}

.modal-header{

    border-bottom:none;

}

.modal-footer{

    border-top:none;

}

.card{

    border-radius:15px;

}

.table thead th{

    white-space:nowrap;

}

/* ===========================
   RESPONSIVE
=========================== */

@media(max-width:768px){

    .content{

        padding:15px;

    }

    .table{

        font-size:13px;

    }

    .btn{

        font-size:12px;

        padding:6px 10px;

    }

    .modal-dialog{

        margin:10px;

    }

}

</style>

<?php include "footer.php"; ?>