<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: booking.php");
    exit;
}

$id_user    = $_SESSION['id_user'];
$id_layanan = mysqli_real_escape_string($koneksi, $_POST['id_layanan']);
$tanggal    = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
$jam        = mysqli_real_escape_string($koneksi, $_POST['jam']);
$keluhan    = mysqli_real_escape_string($koneksi, $_POST['keluhan']);

$query = mysqli_query($koneksi, "
INSERT INTO booking
(
    id_user,
    id_layanan,
    tanggal,
    jam,
    keluhan,
    status
)
VALUES
(
    '$id_user',
    '$id_layanan',
    '$tanggal',
    '$jam',
    '$keluhan',
    'Menunggu'
)
");

if ($query) {

    $_SESSION['booking_success'] = true;

    header("Location: booking_saya.php");
    exit;

} else {

    $_SESSION['booking_error'] = "Booking gagal disimpan.";

    header("Location: booking.php");
    exit;

}