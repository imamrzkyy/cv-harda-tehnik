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

// Query khusus untuk riwayat (status Selesai atau Ditolak/Dibatalkan)
$query = mysqli_query($koneksi, "

    SELECT

        booking.*,
        layanan.nama_layanan,
        layanan.harga

    FROM booking

    JOIN layanan
        ON booking.id_layanan = layanan.id_layanan

    WHERE booking.id_user = '$id_user'
    AND booking.status IN ('Selesai', 'Ditolak', 'Dibatalkan')

    ORDER BY booking.created_at DESC

");

?>

<style>

.history-title{

    font-weight: 700;

    color: #495057;

}

.history-card{

    border: none;

    border-radius: 20px;

    overflow: hidden;

    transition: .3s;

    box-shadow: 0 8px 25px rgba(0,0,0,.06);

    background: #fff;

    height: 100%;

}

.history-card:hover{

    transform: translateY(-5px);

    box-shadow: 0 15px 35px rgba(0,0,0,.1);

}

.history-header{

    background: linear-gradient(135deg, #495057, #343a40);

    color: #fff;

    padding: 18px 22px;

}

.history-header h5{

    margin: 0;

    font-weight: 600;

}

.history-body{

    padding: 25px;

}

.history-item{

    display: flex;

    align-items: flex-start;

    margin-bottom: 18px;

}

.history-item:last-child{

    margin-bottom: 0;

}

.history-icon{

    width: 45px;

    height: 45px;

    border-radius: 12px;

    background: #f1f3f5;

    color: #495057;

    display: flex;

    align-items: center;

    justify-content: center;

    font-size: 20px;

    margin-right: 15px;

    flex-shrink: 0;

}

.history-label{

    font-size: 13px;

    color: #adb5bd;

}

.history-value{

    font-size: 16px;

    font-weight: 600;

    color: #495057;

}

.history-footer{

    padding: 18px 22px;

    background: #f8f9fa;

    border-top: 1px solid #eee;

}

.empty-history{

    padding: 80px 20px;

    text-align: center;

}

.empty-history i{

    font-size: 70px;

    color: #adb5bd;

    margin-bottom: 20px;

}

.badge-status{

    padding: 8px 16px;

    border-radius: 30px;

    font-size: 12px;

    letter-spacing: .5px;

}

</style>

<section class="py-5 mt-5">

<div class="container">

<div class="text-center mb-5">

<h2 class="history-title">

<i class="bi bi-clock-history"></i>

Riwayat Pesanan & Layanan

</h2>

<p class="text-muted">

Arsip layanan yang sudah selesai dikerjakan atau dibatalkan.

</p>

</div>

<?php if (mysqli_num_rows($query) > 0) { ?>

<div class="row">

    <?php while ($row = mysqli_fetch_assoc($query)) { ?>

    <div class="col-lg-6 mb-4">

        <div class="history-card">

            <div class="history-header d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    <i class="bi bi-tools me-1"></i>
                    <?= $row['nama_layanan']; ?>
                </h5>

                <?php
                if ($row['status'] == "Selesai") {
                    echo '<span class="badge bg-success badge-status"><i class="bi bi-check-circle-fill me-1"></i> Selesai</span>';
                } elseif ($row['status'] == "Ditolak") {
                    echo '<span class="badge bg-danger badge-status"><i class="bi bi-x-circle-fill me-1"></i> Ditolak</span>';
                } else {
                    echo '<span class="badge bg-secondary badge-status"><i class="bi bi-dash-circle-fill me-1"></i> ' . $row['status'] . '</span>';
                }
                ?>

            </div>

            <div class="history-body">

                <div class="history-item">

                    <div class="history-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>

                    <div>
                        <div class="history-label">Tanggal Pelaksanaan</div>
                        <div class="history-value">
                            <?= date('d F Y', strtotime($row['tanggal'])); ?>
                        </div>
                    </div>

                </div>

                <div class="history-item">

                    <div class="history-icon">
                        <i class="bi bi-clock"></i>
                    </div>

                    <div>
                        <div class="history-label">Jam</div>
                        <div class="history-value">
                            <?= substr($row['jam'], 0, 5); ?> WIB
                        </div>
                    </div>

                </div>

                <div class="history-item">

                    <div class="history-icon">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div>
                        <div class="history-label">Total Biaya</div>
                        <div class="history-value text-success">
                            Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                        </div>
                    </div>

                </div>

                <div class="history-item">

                    <div class="history-icon">
                        <i class="bi bi-chat-text"></i>
                    </div>

                    <div>
                        <div class="history-label">Keluhan Awal</div>
                        <div class="history-value">
                            <?= nl2br(htmlspecialchars($row['keluhan'])); ?>
                        </div>
                    </div>

                </div>

            </div>

            <div class="history-footer d-flex justify-content-between align-items-center">
                <span class="text-muted small">
                    <i class="bi bi-info-circle"></i> Transaksi Arsip
                </span>

                <a href="detail_booking.php?id=<?= $row['id_booking']; ?>"
                    class="btn btn-dark btn-sm rounded-pill px-4">

                    <i class="bi bi-eye"></i>
                    Detail Selesai

                </a>

            </div>

        </div>

    </div>

    <?php } ?>

</div>

<?php } else { ?>

<div class="empty-history">

    <i class="bi bi-archive"></i>

    <h3>Belum Ada Riwayat</h3>

    <p class="text-muted mb-4">
        Belum ada riwayat layanan yang berstatus selesai atau dibatalkan.
    </p>

    <a href="booking_saya.php" class="btn btn-outline-dark rounded-pill px-4">

        <i class="bi bi-arrow-left"></i>
        Kembali ke Booking Aktif

    </a>

</div>

<?php } ?>

</div>

</section>

<?php include "../includes/footer.php"; ?>