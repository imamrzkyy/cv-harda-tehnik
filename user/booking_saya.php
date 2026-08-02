<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: login.php");
    exit;

}

include "../config/koneksi.php";
include "../includes/header.php";
include "../includes/navbar.php";

$id_user = $_SESSION['id_user'];

$booking_success = false;

if (isset($_SESSION['booking_success'])) {

    $booking_success = true;

    unset($_SESSION['booking_success']);

}

$query = mysqli_query($koneksi, "

    SELECT

        booking.*,
        layanan.nama_layanan,
        layanan.harga

    FROM booking

    JOIN layanan
        ON booking.id_layanan = layanan.id_layanan

    WHERE booking.id_user = '$id_user'
    AND booking.status != 'Selesai'

    ORDER BY booking.created_at DESC

");

?>

<style>

.booking-title{

    font-weight:700;

    color:#0d6efd;

}

.booking-card{

    border:none;

    border-radius:20px;

    overflow:hidden;

    transition:.3s;

    box-shadow:0 8px 25px rgba(0,0,0,.08);

    height:100%;

}

.booking-card:hover{

    transform:translateY(-6px);

    box-shadow:0 18px 40px rgba(0,0,0,.15);

}

.booking-header{

    background:linear-gradient(135deg,#0d6efd,#0a58ca);

    color:#fff;

    padding:18px 22px;

}

.booking-header h5{

    margin:0;

    font-weight:600;

}

.booking-body{

    padding:25px;

}

.booking-item{

    display:flex;

    align-items:flex-start;

    margin-bottom:18px;

}

.booking-item:last-child{

    margin-bottom:0;

}

.booking-icon{

    width:45px;

    height:45px;

    border-radius:50%;

    background:#eef5ff;

    color:#0d6efd;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:20px;

    margin-right:15px;

    flex-shrink:0;

}

.booking-label{

    font-size:13px;

    color:#888;

}

.booking-value{

    font-size:16px;

    font-weight:600;

    color:#333;

}

.booking-footer{

    padding:20px;

    background:#fafafa;

    border-top:1px solid #eee;

}

.empty-booking{

    padding:80px 20px;

    text-align:center;

}

.empty-booking i{

    font-size:70px;

    color:#0d6efd;

    margin-bottom:20px;

}

.badge-status{

    padding:8px 18px;

    border-radius:30px;

    font-size:13px;

}

</style>

<section class="py-5 mt-5">

<div class="container">

<div class="text-center mb-5">

<h2 class="booking-title">

<i class="bi bi-calendar-check-fill"></i>

Booking Saya

</h2>

<p class="text-muted">

Semua riwayat booking layanan Anda ada di sini.

</p>

</div>


<?php if (mysqli_num_rows($query) > 0) { ?>

<div class="row">

    <?php while ($row = mysqli_fetch_assoc($query)) { ?>

    <div class="col-lg-6 mb-4">

        <div class="booking-card">

            <div class="booking-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="bi bi-tools"></i>
                    <?= $row['nama_layanan']; ?>
                </h5>

                <?php
                if ($row['status'] == "Menunggu") {
                    echo '<span class="badge bg-warning text-dark badge-status">Menunggu</span>';
                } elseif ($row['status'] == "Diproses") {
                    echo '<span class="badge bg-primary badge-status">Diproses</span>';
                } elseif ($row['status'] == "Selesai") {
                    echo '<span class="badge bg-success badge-status">Selesai</span>';
                } else {
                    echo '<span class="badge bg-danger badge-status">' . $row['status'] . '</span>';
                }
                ?>

            </div>

            <div class="booking-body">

                <div class="booking-item">

                    <div class="booking-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>

                    <div>
                        <div class="booking-label">Tanggal Booking</div>
                        <div class="booking-value">
                            <?= date('d F Y', strtotime($row['tanggal'])); ?>
                        </div>
                    </div>

                </div>

                <div class="booking-item">

                    <div class="booking-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>

                    <div>
                        <div class="booking-label">Jam Booking</div>
                        <div class="booking-value">
                            <?= substr($row['jam'], 0, 5); ?> WIB
                        </div>
                    </div>

                </div>

                <div class="booking-item">

                    <div class="booking-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>

                    <div>
                        <div class="booking-label">Biaya Layanan</div>
                        <div class="booking-value text-success">
                            Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                        </div>
                    </div>

                </div>

                <div class="booking-item">

                    <div class="booking-icon">
                        <i class="bi bi-chat-left-text"></i>
                    </div>

                    <div>
                        <div class="booking-label">Keluhan</div>
                        <div class="booking-value">
                            <?= nl2br(htmlspecialchars($row['keluhan'])); ?>
                        </div>
                    </div>

                </div>

            </div>

            <div class="booking-footer text-end">

                <a href="detail_booking.php?id=<?= $row['id_booking']; ?>"
                    class="btn btn-primary rounded-pill px-4">

                    <i class="bi bi-eye"></i>
                    Detail Booking

                </a>

            </div>

        </div>

    </div>

    <?php } ?>

</div>

<?php } else { ?>

<div class="empty-booking">

    <i class="bi bi-calendar-x"></i>

    <h3>Belum Ada Booking</h3>

    <p class="text-muted mb-4">
        Anda belum pernah melakukan booking layanan.
    </p>

    <a href="booking.php" class="btn btn-primary btn-lg rounded-pill px-4">

        <i class="bi bi-plus-circle"></i>
        Booking Sekarang

    </a>

</div>

<?php } ?>

</div>

</div>

</div>

</section>

<?php include "../includes/footer.php"; ?>

<?php if ($booking_success) { ?>

<script>
Swal.fire({
    icon: "success",
    title: "Booking Berhasil",
    text: "Booking berhasil dibuat. Silakan buka Detail Booking lalu kirim booking ke WhatsApp Admin untuk melakukan pembayaran.",
    confirmButtonColor: "#0d6efd"
});
</script>

<?php } ?>