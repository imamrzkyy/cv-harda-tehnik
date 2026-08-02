<?php

session_start();
include '../config/koneksi.php';

// Cek apakah form dikirim menggunakan POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: login.php");
    exit;
}

$email    = mysqli_real_escape_string($koneksi, $_POST['email']);
$password = $_POST['password'];

// Cari user berdasarkan email
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email'");

if (mysqli_num_rows($query) == 0) {
    header("Location: login.php?pesan=email");
    exit;
}

$user = mysqli_fetch_assoc($query);

// Cek status akun
if ($user['status'] != 'Aktif') {
    header("Location: login.php?pesan=nonaktif");
    exit;
}

// Cek password
if (!password_verify($password, $user['password'])) {
    header("Location: login.php?pesan=password");
    exit;
}

// =======================
// Simpan Session Login
// =======================
$_SESSION['login']  = true;
$_SESSION['user']   = $user;

$_SESSION['id_user'] = $user['id_user'];
$_SESSION['nama']    = $user['nama'];
$_SESSION['email']   = $user['email'];
$_SESSION['role']    = $user['role'];
$_SESSION['foto']    = $user['foto'];

// Redirect berdasarkan role
if ($user['role'] == 'admin') {
    header("Location: ../admin/index.php");
} else {
    header("Location: ../index.php");
}

exit;