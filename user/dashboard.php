<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

include '../config/helper.php';
include '../includes/header.php';
?>

<style>

body{
    background:#f5f7fb;
}

.dashboard-header{

    background:linear-gradient(135deg,#0d6efd,#4da3ff);
    color:#fff;
    border-radius:20px;
    padding:35px;

}

.profile-img{

    width:90px;
    height:90px;

    border-radius:50%;
    object-fit:cover;

    border:4px solid rgba(255,255,255,.4);

}

.stat-card{

    background:#fff;
    border:none;
    border-radius:18px;

    transition:.3s;

    box-shadow:0 8px 25px rgba(0,0,0,.08);

}

.stat-card:hover{

    transform:translateY(-5px);

}

.stat-icon{

    width:65px;
    height:65px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:28px;

    color:#fff;

}

.menu-card{

    border:none;
    border-radius:18px;

    transition:.3s;

    box-shadow:0 8px 20px rgba(0,0,0,.08);

}

.menu-card:hover{

    transform:translateY(-6px);

}

.menu-icon{

    font-size:40px;

    color:#0d6efd;

}

</style>

<div class="container py-5">

<div class="dashboard-header mb-5">

<div class="row align-items-center">

<div class="col-md-8">

<h2>

Selamat Datang,

<b><?= $_SESSION['nama']; ?></b> 👋

</h2>

<p class="mb-0">

Selamat datang di Dashboard CV. Harda Tehnik Mandiri.

Silakan lakukan booking service atau lihat riwayat pesanan Anda.

</p>

</div>

<div class="col-md-4 text-md-end mt-4 mt-md-0">

<img
src="<?= $base_url ?>assets/images/user/default.png"
class="profile-img">

</div>

</div>

</div>

<!-- Statistik -->

<div class="row g-4 mb-5">

<div class="col-lg-4">

<div class="card stat-card">

<div class="card-body d-flex align-items-center">

<div class="stat-icon bg-primary">

<i class="bi bi-calendar-check"></i>

</div>

<div class="ms-3">

<h3 class="mb-0">

0

</h3>

<small>

Booking Aktif

</small>

</div>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card stat-card">

<div class="card-body d-flex align-items-center">

<div class="stat-icon bg-success">

<i class="bi bi-check-circle"></i>

</div>

<div class="ms-3">

<h3 class="mb-0">

0

</h3>

<small>

Booking Selesai

</small>

</div>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card stat-card">

<div class="card-body d-flex align-items-center">

<div class="stat-icon bg-warning">

<i class="bi bi-star"></i>

</div>

<div class="ms-3">

<h3 class="mb-0">

User

</h3>

<small>

Role Akun

</small>

</div>

</div>

</div>

</div>

</div>

<!-- Menu -->

<div class="row g-4">

<div class="col-lg-3 col-md-6">

<div class="card menu-card">

<div class="card-body text-center">

<i class="bi bi-tools menu-icon"></i>

<h5 class="mt-3">

Booking Service

</h5>

<a href="booking.php" class="btn btn-primary mt-3">

Booking

</a>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card menu-card">

<div class="card-body text-center">

<i class="bi bi-clock-history menu-icon"></i>

<h5 class="mt-3">

Riwayat

</h5>

<a href="riwayat.php" class="btn btn-primary mt-3">

Lihat

</a>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card menu-card">

<div class="card-body text-center">

<i class="bi bi-person-circle menu-icon"></i>

<h5 class="mt-3">

Profil

</h5>

<a href="profil.php" class="btn btn-primary mt-3">

Profil Saya

</a>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="card menu-card">

<div class="card-body text-center">

<i class="bi bi-box-arrow-right menu-icon text-danger"></i>

<h5 class="mt-3">

Logout

</h5>

<a href="logout.php" class="btn btn-danger mt-3">

Keluar

</a>

</div>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>