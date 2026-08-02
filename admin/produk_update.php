<?php

include "../includes/auth.php";
include "../config/koneksi.php";

// Set header response agar dibaca sebagai JSON oleh JavaScript
header('Content-Type: application/json');

// Karena dikirim pakai AJAX/FormData, pastikan id_produk ada
if(!isset($_POST['id_produk']) || empty($_POST['id_produk'])){
    echo json_encode([
        "status" => false,
        "pesan" => "ID Produk tidak valid."
    ]);
    exit;
}

/* ===========================
   AMBIL DATA
=========================== */

$id_produk     = (int) $_POST['id_produk'];
$id_kategori   = (int) $_POST['id_kategori'];

$nama_produk   = mysqli_real_escape_string($koneksi, trim($_POST['nama_produk']));
$merk          = mysqli_real_escape_string($koneksi, trim($_POST['merk']));
$pk_ac         = mysqli_real_escape_string($koneksi, trim($_POST['pk_ac']));
$kondisi       = mysqli_real_escape_string($koneksi, $_POST['kondisi']);
$harga         = (float) $_POST['harga'];
$stok          = (int) $_POST['stok'];
$status        = mysqli_real_escape_string($koneksi, $_POST['status']);
$deskripsi     = mysqli_real_escape_string($koneksi, trim($_POST['deskripsi']));

/* ===========================
   VALIDASI
=========================== */

if($nama_produk == ""){
    echo json_encode([
        "status" => false,
        "pesan" => "Nama produk wajib diisi."
    ]);
    exit;
}

/* ===========================
   AMBIL GAMBAR LAMA
=========================== */

$q = mysqli_query($koneksi,"
    SELECT gambar
    FROM produk
    WHERE id_produk='$id_produk'
");

$data = mysqli_fetch_assoc($q);
$gambar = $data['gambar'] ?? '';

/* ===========================
   JIKA ADA GAMBAR BARU
=========================== */

if (
    isset($_FILES['gambar']) &&
    $_FILES['gambar']['error'] === UPLOAD_ERR_OK &&
    !empty($_FILES['gambar']['name'])
) {

    $folder = "../uploads/produk/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png','webp'];

    if (in_array($ext, $allowed)) {

        $namaBaru = uniqid('produk_') . "." . $ext;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $folder . $namaBaru)) {

            // hapus gambar lama jika ada
            if (!empty($gambar) && file_exists($folder . $gambar)) {
                unlink($folder . $gambar);
            }

            $gambar = $namaBaru;

        } else {
            echo json_encode([
                "status" => false,
                "pesan" => "Gagal upload gambar."
            ]);
            exit;
        }

    } else {
        echo json_encode([
            "status" => false,
            "pesan" => "Format gambar tidak didukung (harus jpg, jpeg, png, webp)."
        ]);
        exit;
    }
}

/* ===========================
   UPDATE DATABASE
=========================== */

$sql = "
UPDATE produk SET
    id_kategori='$id_kategori',
    nama_produk='$nama_produk',
    merk='$merk',
    pk_ac='$pk_ac',
    kondisi='$kondisi',
    harga='$harga',
    stok='$stok',
    deskripsi='$deskripsi',
    gambar='$gambar',
    status='$status'
WHERE id_produk='$id_produk'
";

$update = mysqli_query($koneksi, $sql);

if($update){
    echo json_encode([
        "status" => true,
        "pesan" => "Produk berhasil diperbarui."
    ]);
} else {
    echo json_encode([
        "status" => false,
        "pesan" => mysqli_error($koneksi)
    ]);
}
exit;
?>