<?php
session_start();
include "../config/koneksi.php";

// Cek keamanan akses
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['kirim'])) {
    $id_user = $_SESSION['id_user']; // Mengambil ID user yang sedang login
    $rating  = (int)$_POST['rating'];
    $isi_testimoni = mysqli_real_escape_string($koneksi, $_POST['isi_testimoni']);
    
    // Ambil data pendukung user (nama, alamat, foto) langsung dari tabel user agar sinkron dengan query di index.php
    $q_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
    $usr = mysqli_fetch_assoc($q_user);

    $nama   = $usr['nama'] ?? 'Pelanggan';
    $alamat = $usr['alamat'] ?? '-';
    $foto   = $usr['foto'] ?? 'default.png';
    $status = 'Pending'; // Default pending agar diseleksi admin dulu, atau bisa langsung 'Tampil'

    // Simpan ke database
    $query = "INSERT INTO testimoni (id_user, nama, alamat, foto, rating, isi_testimoni, status) 
              VALUES ('$id_user', '$nama', '$alamat', '$foto', '$rating', '$isi_testimoni', '$status')";
    
    $simpan = mysqli_query($koneksi, $query);

    if ($simpan) {
        echo "<script>
                alert('Testimoni berhasil dikirim dan menunggu persetujuan admin!');
                window.location.href='../index.php#testimoni';
              </script>";
    } else {
        echo "<script>
                alert('Gagal mengirim testimoni: " . mysqli_error($koneksi) . "');
                window.location.href='../index.php#testimoni';
              </script>";
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>