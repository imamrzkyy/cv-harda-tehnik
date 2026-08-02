<?php
session_start();

include "../config/koneksi.php";

// 1. PROSES UBAH STATUS PELANGGAN (Aktif / Nonaktif)
if (isset($_GET['ubah_status'])) {
    $id_user = (int)$_GET['ubah_status'];
    $status_sekarang = $_GET['status_sekarang'];
    
    $status_baru = ($status_sekarang == 'Aktif') ? 'Nonaktif' : 'Aktif';

    $update = mysqli_query($koneksi, "UPDATE user SET status = '$status_baru' WHERE id_user = '$id_user'");
    
    if ($update) {
        header("Location: pelanggan.php?pesan=status_sukses");
        exit;
    }
}

// 2. PROSES EDIT DATA PELANGGAN
if (isset($_POST['edit_pelanggan'])) {
    $id_user = (int)$_POST['id_user'];
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email   = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_hp   = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat  = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $status  = mysqli_real_escape_string($koneksi, $_POST['status']);

    $query_edit = "UPDATE user SET nama = '$nama', email = '$email', no_hp = '$no_hp', alamat = '$alamat', status = '$status' WHERE id_user = '$id_user'";
    $update = mysqli_query($koneksi, $query_edit);

    if ($update) {
        header("Location: pelanggan.php?pesan=edit_sukses");
        exit;
    }
}

// 3. PROSES HAPUS PELANGGAN
if (isset($_GET['hapus'])) {
    $id_user = (int)$_GET['hapus'];
    
    $hapus = mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id_user' AND role = 'user'");
    
    if ($hapus) {
        header("Location: pelanggan.php?pesan=hapus_sukses");
        exit;
    }
}

// Ambil data semua user dengan role 'user'
$query_pelanggan = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'user' ORDER BY created_at DESC");

// Panggil Header & Sidebar
include "header.php";
include "sidebar.php";
?>

<!-- KONTEN UTAMA MENGGUNAKAN KELAS .content SESUAI TEMPLATE ANDA -->
<main class="content">
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div>
            <h2 class="page-title"><i class="bi bi-people-fill me-2"></i> Kelola Data Pelanggan</h2>
            <p class="text-muted mb-0">Daftar akun pelanggan/user yang terdaftar pada sistem CV. Harda Teknik Mandiri.</p>
        </div>
    </div>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'status_sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Status akun pelanggan berhasil diubah!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'edit_sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data pelanggan berhasil diperbarui!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus_sukses'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Data pelanggan berhasil dihapus!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($query_pelanggan)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['no_hp']); ?></td>
                            <td><?= htmlspecialchars($row['alamat'] ? $row['alamat'] : '-'); ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 'Aktif'): ?>
                                    <span class="badge bg-success px-3 py-2 rounded-pill">Aktif</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-2 rounded-pill">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <!-- Tombol Edit (Memicu Modal) -->
                                <button type="button" class="btn btn-warning btn-sm text-white" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal<?= $row['id_user']; ?>" 
                                        title="Edit Pelanggan">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                <!-- Tombol Ganti Status Aktif/Nonaktif -->
                                <a href="pelanggan.php?ubah_status=<?= $row['id_user']; ?>&status_sekarang=<?= $row['status']; ?>" 
                                   class="btn btn-sm <?= ($row['status'] == 'Aktif') ? 'btn-outline-secondary' : 'btn-outline-success'; ?>" 
                                   title="Ubah Status">
                                    <i class="bi bi-toggle-on"></i>
                                </a>
                                
                                <!-- Tombol Hapus Pelanggan -->
                                <a href="pelanggan.php?hapus=<?= $row['id_user']; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus akun pelanggan ini?')" 
                                   class="btn btn-danger btn-sm" 
                                   title="Hapus Pelanggan">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <!-- MODAL EDIT PELANGGAN -->
                        <div class="modal fade" id="editModal<?= $row['id_user']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="" method="POST">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="editModalLabel">Edit Data Pelanggan</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <input type="hidden" name="id_user" value="<?= $row['id_user']; ?>">
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama']); ?>" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Email</label>
                                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($row['email']); ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">No HP</label>
                                                <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($row['no_hp']); ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Alamat</label>
                                                <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($row['alamat']); ?></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Status Akun</label>
                                                <select name="status" class="form-select" required>
                                                    <option value="Aktif" <?= ($row['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                                    <option value="Nonaktif" <?= ($row['status'] == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" name="edit_pelanggan" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- END MODAL -->

                        <?php endwhile; ?>
                        
                        <?php if (mysqli_num_rows($query_pelanggan) == 0): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data pelanggan terdaftar.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<?php include "footer.php"; ?>