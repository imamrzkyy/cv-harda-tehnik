<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "../config/koneksi.php";
include "../includes/header.php";
include "../includes/navbar.php";

if (!isset($_GET['id'])) {
    header("Location: booking_saya.php");
    exit;
}

$id_booking = (int)$_GET['id'];
$id_user    = $_SESSION['id_user'];

$query = mysqli_query($koneksi, "
SELECT
    booking.*,
    layanan.nama_layanan,
    layanan.harga,
    user.nama,
    user.no_hp
FROM booking
JOIN layanan
ON booking.id_layanan = layanan.id_layanan
JOIN user
ON booking.id_user = user.id_user
WHERE booking.id_booking='$id_booking'
AND booking.id_user='$id_user'
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<div class='container py-5 mt-5'>
            <div class='alert alert-danger'>
                Data booking tidak ditemukan.
            </div>
          </div>";
    include "../includes/footer.php";
    exit;
}

// Cek apakah statusnya sudah selesai
$isSelesai = ($data['status'] == 'Selesai');

$nomor_admin = "628567024777";
$pesan = "Halo Admin CV. Harda Tehnik Mandiri\n\nSaya ingin menanyakan status booking nomor: BK" . str_pad($data['id_booking'],5,'0',STR_PAD_LEFT);
$linkWA = "https://wa.me/".$nomor_admin."?text=".urlencode($pesan);
?>

<section class="py-5 mt-5">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-8">

<div class="card shadow border-0 rounded-4 overflow-hidden">

<!-- Header Berubah Warna Berdasarkan Status -->
<div class="card-header <?= $isSelesai ? 'bg-success' : 'bg-primary'; ?> text-white p-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="mb-0">
            <i class="bi <?= $isSelesai ? 'bi-check-circle-fill' : 'bi-receipt'; ?>"></i>
            <?= $isSelesai ? 'Detail Layanan Selesai' : 'Detail Booking'; ?>
        </h3>
        <span class="badge bg-light text-dark px-3 py-2 rounded-pill fw-bold">
            <?= strtoupper($data['status']); ?>
        </span>
    </div>
</div>

<div class="card-body p-4">

<?php if ($isSelesai): ?>
    <!-- Alert Khusus Riwayat Selesai -->
    <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-patch-check-fill fs-3 me-3"></i>
        <div>
            Layanan ini telah selesai dikerjakan oleh teknisi kami. Terima kasih telah menggunakan jasa CV. Harda Tehnik Mandiri!
        </div>
    </div>
<?php endif; ?>

<table class="table table-bordered">
<tr>
<th width="35%">No Booking</th>
<td>BK<?= str_pad($data['id_booking'],5,'0',STR_PAD_LEFT); ?></td>
</tr>

<tr>
<th>Nama Pelanggan</th>
<td><?= htmlspecialchars($data['nama']); ?></td>
</tr>

<tr>
<th>Jenis Jasa</th>
<td><?= htmlspecialchars($data['nama_layanan']); ?></td>
</tr>

<tr>
<th>Harga / Biaya</th>
<td class="fw-bold text-success">
Rp <?= number_format($data['harga'],0,',','.'); ?>
</td>
</tr>

<tr>
<th>Tanggal Pelaksanaan</th>
<td>
<?= date('d F Y',strtotime($data['tanggal'])); ?>
</td>
</tr>

<tr>
<th>Jam Pengerjaan</th>
<td>
<?= substr($data['jam'],0,5); ?> WIB
</td>
</tr>

<tr>
<th>Keluhan / Catatan</th>
<td><?= nl2br(htmlspecialchars($data['keluhan'])); ?></td>
</tr>

<tr>
<th>Status Saat Ini</th>
<td>
<?php
if($data['status']=="Menunggu"){
    echo '<span class="badge bg-warning text-dark">'.$data['status'].'</span>';
}elseif($data['status']=="Diproses"){
    echo '<span class="badge bg-primary">'.$data['status'].'</span>';
}elseif($data['status']=="Selesai"){
    echo '<span class="badge bg-success">'.$data['status'].'</span>';
}else{
    echo '<span class="badge bg-danger">'.$data['status'].'</span>';
}
?>
</td>
</tr>

</table>

<?php if (!$isSelesai): ?>
    <!-- TAMPILAN KHUSUS BOOKING AKTIF (BELUM SELESAI) -->
    <div class="alert alert-warning mt-4">
        <h5><i class="bi bi-exclamation-triangle-fill"></i> Perhatian</h5>
        <p class="mb-2">Silakan kirim data booking ini ke <b>WhatsApp Admin</b> untuk melakukan konfirmasi booking dan pembayaran.</p>
        <p class="mb-0">Booking akan diproses setelah pembayaran berhasil dikonfirmasi oleh admin.</p>
    </div>

    <div class="text-center mt-4">
        <a href="<?= $linkWA; ?>" class="btn btn-success btn-lg rounded-pill px-4" target="_blank">
            <i class="bi bi-whatsapp"></i> Kirim Booking ke WhatsApp Admin
        </a>
    </div>

    <div class="text-center mt-3">
        <a href="booking_saya.php" class="btn btn-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Booking Saya
        </a>
    </div>

<?php else: ?>
    <!-- TAMPILAN KHUSUS RIWAYAT SELESAI -->
    <div class="d-flex justify-content-between mt-4">
        <a href="riwayat_booking.php" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
        </a>
        <a href="booking.php" class="btn btn-success rounded-pill px-4">
            <i class="bi bi-arrow-repeat"></i> Booking Lagi Layanan Ini
        </a>
    </div>
<?php endif; ?>

</div>

</div>

</div>
</div>
</div>
</section>

<?php include "../includes/footer.php"; ?>