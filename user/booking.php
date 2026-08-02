<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include "../config/koneksi.php";
include "../includes/header.php";
include "../includes/navbar.php";

$id_user = $_SESSION['id_user'];

$layanan = mysqli_query($koneksi, "
    SELECT *
    FROM layanan
    WHERE status = 'Aktif'
    ORDER BY nama_layanan ASC
");
?>

<section class="py-5 mt-5">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">

                        <h3 class="mb-0">
                            Booking Service AC
                        </h3>

                    </div>

                    <div class="card-body">

                        <form action="proses_booking.php" method="POST">

                            <input
                                type="hidden"
                                name="id_user"
                                value="<?= $id_user; ?>">

                            <!-- Pilih Layanan -->

                            <div class="mb-3">

                                <label class="form-label">
                                    Pilih Layanan
                                </label>

                                <select
                                    name="id_layanan"
                                    id="id_layanan"
                                    class="form-select"
                                    required>

                                    <option value="">
                                        -- Pilih Layanan --
                                    </option>

                                    <?php while ($l = mysqli_fetch_assoc($layanan)) { ?>

                                        <option
                                            value="<?= $l['id_layanan']; ?>"
                                            data-harga="<?= $l['harga']; ?>"
                                            data-estimasi="<?= $l['estimasi']; ?>">

                                            <?= $l['nama_layanan']; ?>

                                        </option>

                                    <?php } ?>

                                </select>

                            </div>

                            <!-- Detail Layanan -->

                            <div class="row mb-3">

                                <div class="col-md-6">

                                    <div class="alert alert-info">

                                        <strong>Harga</strong>

                                        <br>

                                        <span id="hargaLayanan">
                                            Silakan pilih layanan
                                        </span>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="alert alert-success">

                                        <strong>Estimasi Pengerjaan</strong>

                                        <br>

                                        <span id="estimasiLayanan">
                                            -
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <!-- Tanggal dan Jam -->

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Tanggal Booking
                                    </label>

                                    <input
                                        type="date"
                                        name="tanggal"
                                        class="form-control"
                                        min="<?= date('Y-m-d'); ?>"
                                        required>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">
                                        Jam Booking
                                    </label>

                                    <input
                                        type="time"
                                        name="jam"
                                        class="form-control"
                                        required>

                                </div>

                            </div>

                            <!-- Keluhan -->

                            <div class="mb-3">

                                <label class="form-label">
                                    Keluhan
                                </label>

                                <textarea
                                    name="keluhan"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Contoh: AC tidak dingin, bocor, berisik..."
                                    required></textarea>

                            </div>

                            <!-- Tombol -->

                            <div class="text-end">

                                <a href="../index.php" class="btn btn-secondary">

                                    Kembali

                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-primary">

                                    <i class="bi bi-send"></i>

                                    Booking Sekarang

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<script>

const layanan = document.getElementById("id_layanan");
const harga = document.getElementById("hargaLayanan");
const estimasi = document.getElementById("estimasiLayanan");

layanan.addEventListener("change", function () {

    const option = this.options[this.selectedIndex];

    if (option.value === "") {

        harga.innerHTML = "Silakan pilih layanan";
        estimasi.innerHTML = "-";

        return;
    }

    const hargaLayanan = parseFloat(option.dataset.harga).toLocaleString("id-ID");

    harga.innerHTML = "<strong>Rp " + hargaLayanan + "</strong>";

    estimasi.innerHTML = option.dataset.estimasi;

});

</script>

<?php include "../includes/footer.php"; ?>