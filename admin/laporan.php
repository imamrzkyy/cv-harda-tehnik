<?php
session_start();

include "../config/koneksi.php";

// Ambil rentang tanggal dari filter jika ada
$dari_tanggal = $_GET['dari'] ?? '';
$sampai_tanggal = $_GET['sampai'] ?? '';

// Query dasar untuk data laporan (disesuaikan agar aman dari error kolom produk)
$query_str = "
SELECT
    booking.*,
    user.nama AS nama_pelanggan,
    layanan.nama_layanan
FROM booking
LEFT JOIN user
    ON booking.id_user = user.id_user
LEFT JOIN layanan
    ON booking.id_layanan = layanan.id_layanan
WHERE booking.status = 'Selesai'
AND booking.status_pembayaran = 'Lunas'
";

if (!empty($dari_tanggal) && !empty($sampai_tanggal)) {
    // Sesuaikan 'tanggal' jika nama kolom di database Anda berbeda
    $query_str .= " AND DATE(booking.tanggal) BETWEEN '$dari_tanggal' AND '$sampai_tanggal'";
}

// Urutkan berdasarkan ID atau kolom tanggal yang valid
$query_str .= " ORDER BY booking.id_booking DESC";
$query = mysqli_query($koneksi, $query_str);

// Hitung total pendapatan dan total booking dari hasil filter
$total_pendapatan = 0;
$total_booking = 0;
$data_laporan = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data_laporan[] = $row;
    $total_booking++;
    // Jika status selesai atau disetujui, masuk hitungan pendapatan (sesuaikan dengan kolom status di database Anda)
    if (strtolower($row['status']) == 'selesai') {
        $total_pendapatan += $row['total_biaya'] ?? 0; // Sesuaikan nama kolom harga di database jika berbeda
    }
}

// Panggil header admin
include "header.php";
include "sidebar.php";
?>

<div class="main-content px-4 py-4" style="margin-left: 260px;">
    
    <!-- Judul Halaman -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1"><i class="bi bi-file-earmark-bar-graph me-2 text-primary"></i> Laporan Transaksi & Booking</h3>
            <p class="text-muted small mb-0">Kelola, filter, dan cetak rekapitulasi data laporan CV. Harda Teknik.</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-dark shadow-sm btn-sm px-3 rounded-pill">
                <i class="bi bi-printer me-1"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- KARTU FILTER TANGGAL -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-secondary">Dari Tanggal</label>
                    <input type="date" name="dari" class="form-control rounded-3" value="<?= htmlspecialchars($dari_tanggal); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold small text-secondary">Sampai Tanggal</label>
                    <input type="date" name="sampai" class="form-control rounded-3" value="<?= htmlspecialchars($sampai_tanggal); ?>" required>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 shadow-sm">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <a href="laporan.php" class="btn btn-light border w-100 rounded-3">
                        <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- KARTU RINGKASAN STATISTIK -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 small opacity-75 fw-medium">Total Booking / Transaksi</p>
                        <h3 class="fw-bold mb-0"><?= number_format($total_booking); ?> Data</h3>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-journal-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 bg-success text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-1 small opacity-75 fw-medium">Total Estimasi Pendapatan (Selesai)</p>
                        <h3 class="fw-bold mb-0">Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></h3>
                    </div>
                    <div class="fs-1 opacity-50">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL DATA LAPORAN -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-table me-2"></i> Rincian Data Laporan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-secondary text-uppercase fs-7" style="font-size: 11px;">
                        <tr>
                            <th class="py-3 px-3">No</th>
                            <th class="py-3">Tanggal</th>
                            <th class="py-3">Pelanggan</th>
                            <th class="py-3">Layanan / Produk</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end px-3">Total / Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($data_laporan) > 0): ?>
                            <?php $no = 1; foreach ($data_laporan as $row): ?>
                                <tr>
                                    <td class="px-3"><?= $no++; ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                    <td class="fw-semibold"><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Pelanggan Umum'); ?></td>
                                    <td><?= htmlspecialchars($row['nama_layanan']); ?></td>
                                    <td>
                                        <?php 
                                            $status = strtolower($row['status']);
                                            $badge_bg = 'bg-secondary';
                                            if ($status == 'selesai') $badge_bg = 'bg-success';
                                            elseif ($status == 'proses' || $status == 'disetujui') $badge_bg = 'bg-warning text-dark';
                                            elseif ($status == 'batal') $badge_bg = 'bg-danger';
                                        ?>
                                        <span class="badge <?= $badge_bg; ?> px-2 py-1 rounded-pill"><?= ucfirst($row['status']); ?></span>
                                    </td>
                                    <td class="text-end px-3 fw-bold text-dark">
                                        Rp <?= number_format($row['total_biaya'] ?? 0, 0, ',', '.'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-4 d-block mb-1"></i> Tidak ada data laporan pada rentang tanggal tersebut.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- CSS Tambahan khusus untuk cetak/print laporan agar rapi -->
<style>
@media print {
    .sidebar, .navbar, form, .btn, .main-content {
        margin: 0 !important;
        padding: 0 !important;
    }
    /* Sembunyikan elemen navigasi dan tombol filter saat dicetak */
    form, .btn, .sidebar, header {
        display: none !important;
    }
    body {
        background-color: white !important;
        color: black !important;
    }
}
</style>

<?php 
// Panggil footer admin
include "footer.php"; 
?>