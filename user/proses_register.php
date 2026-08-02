<?php

include '../config/koneksi.php';

$nama      = mysqli_real_escape_string($koneksi,$_POST['nama']);
$email     = mysqli_real_escape_string($koneksi,$_POST['email']);
$no_hp     = mysqli_real_escape_string($koneksi,$_POST['no_hp']);
$alamat    = mysqli_real_escape_string($koneksi,$_POST['alamat']);
$password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

$cek = mysqli_query($koneksi,"SELECT * FROM user WHERE email='$email'");

if(mysqli_num_rows($cek)>0){

    header("Location: register.php?pesan=email");
    exit;

}

mysqli_query($koneksi,"INSERT INTO user
(
nama,
email,
password,
role,
no_hp,
alamat,
foto,
status,
created_at
)

VALUES

(
'$nama',
'$email',
'$password',
'user',
'$no_hp',
'$alamat',
'default.png',
'Aktif',
NOW()
)");

header("Location: login.php?pesan=sukses");
