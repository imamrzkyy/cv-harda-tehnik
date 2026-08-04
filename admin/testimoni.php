<?php
session_start();

include "../config/koneksi.php";

$pesan = "";
$tipe_pesan = "";

// 1. PROSES UPDATE STATUS TESTIMONI (Tampil / Pending / Sembunyi)
if (isset($_GET['aksi']) && $_GET['aksi'] == 'status') {
    $id_testimoni = (int)$_GET['id'];
    $status_baru  = $_GET['status'];

    $update_status = mysqli_query($koneksi, "UPDATE testimoni SET status = '$status_baru' WHERE id_testimoni = '$id_testimoni'");
    if ($update_status) {
        header("Location: testimoni.php?pesan=status_sukses");
        exit;
    }
}

// 2. PROSES HAPUS TESTIMONI
if (isset($_GET['aksi']) && $_GET['aksi'] == 'hapus') {
    $id_testimoni = (int)$_GET['id'];
    
    $hapus = mysqli_query($koneksi, "DELETE FROM testimoni WHERE id_testimoni = '$id_testimoni'");
    if ($hapus) {
        header("Location: testimoni.php?pesan=hapus_sukses");
        exit;
    }
}

// Ambil semua data testimoni dari database
$query_testimoni = mysqli_query($koneksi, "SELECT * FROM testimoni ORDER BY id_testimoni DESC");

// Panggil header admin Anda (sesuaikan path foldernya)
 include "header.php"; 
 include "sidebar.php"; 
?>

<!-- KONTEN UTAMA ADMIN -->
<main class="content py-4"> <!-- Sesuaikan margin-left dengan layout admin Anda -->
    <div class="container-fluid px-4">
        
        <!-- Judul Halaman -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1"><i class="bi bi-chat-quote-fill me-2 text-primary"></i> Kelola Testimoni Pelanggan</h3>
                <p class="text-muted small mb-0">Moderasi ulasan dan testimoni yang dikirimkan oleh pengguna/pelanggan.</p>
            </div>
        </div>

        <!-- Notifikasi Pesan Sukses -->
        <?php if (isset($_GET['pesan'])): ?>
            <?php if ($_GET['pesan'] == 'status_sukses'): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Status testimoni berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif ($_GET['pesan'] == 'hapus_sukses'): ?>
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> Testimoni berhasil dihapus dari sistem.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- KARTU TABEL TESTIMONI -->
        <div class="card border-0 shadow-sm rounded-4 mb-5">
            <div class="card-header bg-white py-3 px-4 border-bottom rounded-top-4">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-table me-2 text-secondary"></i> Daftar Testimoni Masuk</h5>
            </div>
            <div class="card-body p-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="18%">Pelanggan</th>
                                <th width="12%">Rating</th>
                                <th width="35%">Komentar / Ulasan</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($query_testimoni)): ?>
                            <tr>
                                <td class="fw-semibold"><?= $no++; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="../uploads/foto/<?= !empty($row['foto']) ? $row['foto'] : 'default.png'; ?>" 
                                             class="rounded-circle me-2 border" style="width: 38px; height: 38px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 fw-bold fs-6"><?= htmlspecialchars($row['nama']); ?></h6>
                                            <small class="text-muted"><?= htmlspecialchars($row['alamat']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-warning small">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <?php if($i <= $row['rating']): ?>
                                                <i class="bi bi-star-fill"></i>
                                            <?php else: ?>
                                                <i class="bi bi-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="badge bg-light text-dark border mt-1"><?= $row['rating']; ?> / 5</span>
                                </td>
                                <td>
                                    <p class="text-secondary small mb-0 fst-italic">"<?= htmlspecialchars($row['isi_testimoni']); ?>"</p>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status'] == 'Tampil'): ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success-subtle px-3 py-2 rounded-pill fw-semibold">Tampil</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning-subtle px-3 py-2 rounded-pill fw-semibold">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border dropdown-toggle px-3 rounded-3 shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Kelola
                                        </button>
                                        <ul class="dropdown-menu shadow border-0 py-2">
                                            <?php if ($row['status'] == 'Pending'): ?>
                                                <li><a class="dropdown-item text-success fw-medium" href="testimoni.php?aksi=status&id=<?= $row['id_testimoni']; ?>&status=Tampil"><i class="bi bi-check-circle me-2"></i> Setujui (Tampilkan)</a></li>
                                            <?php else: ?>
                                                <li><a class="dropdown-item text-warning fw-medium" href="testimoni.php?aksi=status&id=<?= $row['id_testimoni']; ?>&status=Pending"><i class="bi bi-eye-slash me-2"></i> Sembunyikan</a></li>
                                            <?php endif; ?>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger fw-medium" href="testimoni.php?aksi=hapus&id=<?= $row['id_testimoni']; ?>" onclick="return confirm('Yakin ingin menghapus testimoni ini secara permanen?')"><i class="bi bi-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>

                            <?php if (mysqli_num_rows($query_testimoni) == 0): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">Belum ada data testimoni yang masuk.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>

<?php 
// Panggil footer admin Anda
 include "footer.php"; 
?>