<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "../config/koneksi.php";

$id_user = $_SESSION['id_user'] ?? '';
$pesan = "";
$tipe_pesan = "";

// Ambil data user saat ini dari database
$query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
$data = mysqli_fetch_assoc($query_user);

// 1. PROSES UPDATE PROFIL & FOTO
if (isset($_POST['update_profil'])) {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email  = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_hp  = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $update_foto_query = "";

    // Cek apakah ada file foto yang diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nama_file   = $_FILES['foto']['name'];
        $ukuran_file = $_FILES['foto']['size'];
        $tmp_file    = $_FILES['foto']['tmp_name'];
        $ekstensi    = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        
        $ekstensi_boleh = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ekstensi, $ekstensi_boleh)) {
            // Batasi ukuran maksimal 2MB
            if ($ukuran_file <= 2097152) {
                // Buat nama file unik agar tidak bentrok
                $nama_file_baru = 'user_' . $id_user . '_' . time() . '.' . $ekstensi;
                $folder_tujuan  = '../uploads/foto/';

                // Pastikan folder ada, jika belum buat
                if (!is_dir($folder_tujuan)) {
                    mkdir($folder_tujuan, 0777, true);
                }

                if (move_uploaded_file($tmp_file, $folder_tujuan . $nama_file_baru)) {
                    // Hapus foto lama jika ada dan bukan default
                    if (!empty($data['foto']) && file_exists($folder_tujuan . $data['foto'])) {
                        unlink($folder_tujuan . $data['foto']);
                    }
                    $update_foto_query = ", foto = '$nama_file_baru'";
                } else {
                    $pesan = "Gagal mengunggah gambar ke server!";
                    $tipe_pesan = "danger";
                }
            } else {
                $pesan = "Ukuran foto terlalu besar! Maksimal 2MB.";
                $tipe_pesan = "warning";
            }
        } else {
            $pesan = "Format file foto tidak diizinkan! Gunakan JPG, JPEG, PNG, atau WEBP.";
            $tipe_pesan = "warning";
        }
    }

    // Lanjutkan update jika tidak ada error pada foto (atau jika tidak ganti foto)
    if (empty($pesan) || $tipe_pesan == "success") {
        $update = mysqli_query($koneksi, "UPDATE user SET nama = '$nama', email = '$email', no_hp = '$no_hp', alamat = '$alamat' $update_foto_query WHERE id_user = '$id_user'");

        if ($update) {
            $_SESSION['nama'] = $nama;
            $_SESSION['foto'] = $nama_file_baru;
            $pesan = "Informasi profil berhasil diperbarui!";
            $tipe_pesan = "success";
            
            // Refresh data user terbaru
            $query_user = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
            $data = mysqli_fetch_assoc($query_user);
        } else {
            $pesan = "Gagal memperbarui profil di database: " . mysqli_error($koneksi);
            $tipe_pesan = "danger";
        }
    }
}

// 2. PROSES GANTI PASSWORD
if (isset($_POST['ganti_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    $cek_cocok = false;
    
    if ($data['password'] == $password_lama) {
        $cek_cocok = true;
    } elseif ($data['password'] == md5($password_lama)) {
        $cek_cocok = true;
    } elseif (password_verify($password_lama, $data['password'])) {
        $cek_cocok = true;
    }

    if ($cek_cocok) {
        if ($password_baru == $konfirmasi_password) {
            $pwd_simpan = md5($password_baru); 

            $update_pwd = mysqli_query($koneksi, "UPDATE user SET password = '$pwd_simpan' WHERE id_user = '$id_user'");
            if ($update_pwd) {
                $pesan = "Password berhasil diubah!";
                $tipe_pesan = "success";
            } else {
                $pesan = "Gagal mengubah password!";
                $tipe_pesan = "danger";
            }
        } else {
            $pesan = "Konfirmasi password baru tidak cocok!";
            $tipe_pesan = "warning";
        }
    } else {
        $pesan = "Password lama salah!";
        $tipe_pesan = "danger";
    }
}

// Panggil header dan sidebar/navbar
include "../config/koneksi.php";
include "../includes/header.php";
include "../includes/navbar.php";
?>

<!-- KONTEN UTAMA -->
<main class="content py-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <!-- Judul Halaman -->
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
                    <div>
                        <h3 class="fw-bold text-dark mb-1"><i class="bi bi-person-badge me-2 text-primary"></i> Pengaturan Profil</h3>
                        <p class="text-muted small mb-0">Kelola informasi data diri, foto profil, dan keamanan akun Anda.</p>
                    </div>
                    <a href="index.php" class="btn btn-light border btn-sm px-3 shadow-sm align-self-start align-self-sm-auto">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                </div>

                <?php if (!empty($pesan)): ?>
                    <div class="alert alert-<?= $tipe_pesan; ?> alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                        <i class="bi bi-info-circle-fill me-2"></i> <?= $pesan; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- KARTU UTAMA PROFIL -->
                <div class="card mb-4 overflow-hidden border-0 shadow-sm rounded-4">
                    <div class="profile-header-bg" style="background: linear-gradient(135deg, #0d6efd, #0dcaf0); height: 120px;"></div>
                    <div class="card-body px-3 px-md-4 pb-4 pt-0">
                        
                        <!-- Form Update Profil menggunakan enctype untuk upload file -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            
                           <!-- Avatar & Upload Foto -->
                            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mb-4 gap-3" style="margin-top: -50px;">
                                <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-end gap-3 text-center text-sm-start">
                                    <!-- Elemen Gambar Profil yang diberi ID 'preview-foto' -->
                                    <div class="position-relative">
                                        <?php if (!empty($data['foto']) && file_exists('../uploads/foto/' . $data['foto'])): ?>
                                            <img id="preview-foto" src="../uploads/foto/<?= $data['foto']; ?>" class="rounded-circle shadow bg-white" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid #fff;" alt="Foto Profil">
                                        <?php else: ?>
                                            <img id="preview-foto" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100'%3E%3Crect width='100' height='100' fill='%230d6efd'/%3E%3Ctext x='50%25' y='50%25' dominant-baseline='middle' text-anchor='middle' fill='%23ffffff' font-size='38px' font-family='sans-serif'%3E<?= strtoupper(substr($data['nama'] ?? 'U', 0, 1)); ?><%2Ftext%3E%3C%2Fsvg%3E" class="rounded-circle shadow bg-white" style="width: 100px; height: 100px; object-fit: cover; border: 4px solid #fff;" alt="Foto Profil">
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mb-sm-2">
                                        <h4 class="fw-bold mb-1 text-dark text-break"><?= htmlspecialchars($data['nama']); ?></h4>
                                        <span class="badge bg-primary text-white px-3 py-1 rounded-pill fw-medium">Pelanggan / Member</span>
                                    </div>
                                </div>

                                <!-- Input File Foto dengan ID 'input-foto' -->
                                <div class="bg-white p-3 rounded-4 shadow-sm border w-100" style="max-width: 320px;">
                                    <label class="form-label fw-semibold text-secondary mb-1" style="font-size: 12px;"><i class="bi bi-camera-fill me-1"></i> Ganti Foto Profil</label>
                                    <input type="file" name="foto" id="input-foto" class="form-control form-control-sm rounded-3" accept=".jpg, .jpeg, .png, .webp">
                                    <small class="text-muted d-block mt-1" style="font-size: 10px;">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                                </div>
                            </div>

                            <hr class="text-muted opacity-25 mb-4">

                            <!-- Form Input Data Diri -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-secondary">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control rounded-3" value="<?= htmlspecialchars($data['nama'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-secondary">Alamat Email</label>
                                    <input type="email" name="email" class="form-control rounded-3" value="<?= htmlspecialchars($data['email'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-secondary">Nomor HP / WhatsApp</label>
                                    <input type="text" name="no_hp" class="form-control rounded-3" value="<?= htmlspecialchars($data['no_hp'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small text-secondary">Status Akun</label>
                                    <input type="text" class="form-control rounded-3 bg-light text-success fw-semibold" value="<?= htmlspecialchars($data['status'] ?? 'Aktif'); ?>" readonly>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold small text-secondary">Alamat Lengkap</label>
                                    <textarea name="alamat" class="form-control rounded-3" rows="3"><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="submit" name="update_profil" class="btn btn-primary px-4 rounded-3 shadow-sm">
                                    <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- KARTU GANTI PASSWORD -->
                <div class="card mb-5 border-0 shadow-sm rounded-4">
                    <div class="card-body p-3 p-md-4">
                        <h5 class="fw-bold text-dark mb-2"><i class="bi bi-shield-lock-fill me-2 text-warning"></i> Keamanan & Password</h5>
                        <p class="text-muted small mb-4">Ganti password secara berkala untuk menjaga keamanan akun Anda.</p>
                        
                        <form action="" method="POST">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-secondary">Password Lama</label>
                                    <input type="password" name="password_lama" class="form-control rounded-3" placeholder="••••••••" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-secondary">Password Baru</label>
                                    <input type="password" name="password_baru" class="form-control rounded-3" placeholder="••••••••" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold small text-secondary">Konfirmasi Password</label>
                                    <input type="password" name="konfirmasi_password" class="form-control rounded-3" placeholder="••••••••" required>
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <button type="submit" name="ganti_password" class="btn btn-dark px-4 rounded-3 shadow-sm">
                                    <i class="bi bi-key me-1"></i> Perbarui Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<?php 
// Panggil footer sistem
include "../includes/footer.php"; 
?>