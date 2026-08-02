<?php

include "../includes/auth.php";
include "../config/koneksi.php";

if(!isset($_GET['id'])){

    exit("Data produk tidak ditemukan.");

}

$id = (int)$_GET['id'];

/* ===========================
   AMBIL DATA PRODUK
=========================== */

$query = mysqli_query($koneksi,"

    SELECT *
    FROM produk
    WHERE id_produk='$id'
    LIMIT 1

");

if(mysqli_num_rows($query)==0){

    exit("Produk tidak ditemukan.");

}

$data = mysqli_fetch_assoc($query);

/* ===========================
   AMBIL DATA KATEGORI
=========================== */

$kategori = mysqli_query($koneksi,"

    SELECT *
    FROM kategori_produk
    ORDER BY nama_kategori ASC

");

/* ===========================
   CEK GAMBAR
=========================== */

if(

    !empty($data['gambar']) &&
    file_exists("../uploads/produk/".$data['gambar'])

){

    $gambar = "../uploads/produk/".$data['gambar'];

}else{

    $gambar = "../assets/images/no-image.png";

}

?>

<?php




?>
<form
    id="formEditProduk"
    action="produk_update.php"
    method="POST"
    enctype="multipart/form-data">

    <input
        type="hidden"
        name="id_produk"
        value="<?= $data['id_produk']; ?>">

    <div class="row g-4">

        <!-- KATEGORI -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Kategori Produk

            </label>

            <select
                name="id_kategori"
                class="form-select"
                required>

                <option value="">

                    -- Pilih Kategori --

                </option>

                <?php while($k = mysqli_fetch_assoc($kategori)){ ?>

                    <option
                        value="<?= $k['id_kategori']; ?>"
                        <?= ($k['id_kategori']==$data['id_kategori']) ? "selected" : ""; ?>>

                        <?= htmlspecialchars($k['nama_kategori']); ?>

                    </option>

                <?php } ?>

            </select>

        </div>

        <!-- NAMA PRODUK -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Nama Produk

            </label>

            <input
                type="text"
                name="nama_produk"
                class="form-control"
                value="<?= htmlspecialchars($data['nama_produk']); ?>"
                required>

        </div>

        <!-- MERK -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Merk

            </label>

            <input
                type="text"
                name="merk"
                class="form-control"
                value="<?= htmlspecialchars($data['merk']); ?>">

        </div>

        <!-- PK AC -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                PK AC

            </label>

            <input
                type="text"
                name="pk_ac"
                class="form-control"
                value="<?= htmlspecialchars($data['pk_ac']); ?>">

        </div>

        <!-- KONDISI -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Kondisi

            </label>

            <select
                name="kondisi"
                class="form-select">

                <option
                    value="Baru"
                    <?= ($data['kondisi']=="Baru") ? "selected" : ""; ?>>

                    Baru

                </option>

                <option
                    value="Bekas"
                    <?= ($data['kondisi']=="Bekas") ? "selected" : ""; ?>>

                    Bekas

                </option>

            </select>

        </div>

        <!-- HARGA -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Harga

            </label>

            <input
                type="number"
                name="harga"
                class="form-control"
                value="<?= $data['harga']; ?>"
                min="0">

        </div>

        <!-- STOK -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Stok

            </label>

            <input
                type="number"
                name="stok"
                class="form-control"
                value="<?= $data['stok']; ?>"
                min="0">

        </div>

        <!-- STATUS -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Status

            </label>

            <select
                name="status"
                class="form-select">

                <option
                    value="Tersedia"
                    <?= ($data['status']=="Tersedia") ? "selected" : ""; ?>>

                    Tersedia

                </option>

                <option
                    value="Habis"
                    <?= ($data['status']=="Habis") ? "selected" : ""; ?>>

                    Habis

                </option>

            </select>

        </div>
                <!-- FOTO PRODUK -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Gambar Produk

            </label>

            <input
                type="file"
                name="gambar"
                id="gambarEdit"
                class="form-control"
                accept=".jpg,.jpeg,.png,.webp">

            <small class="text-muted">

                Kosongkan jika tidak ingin mengganti gambar.

            </small>

        </div>

        <!-- PREVIEW GAMBAR -->

        <div class="col-md-6">

            <label class="form-label fw-semibold">

                Preview Gambar

            </label>

            <div class="border rounded p-3 text-center">

                <img
                    id="previewEdit"
                    src="<?= $gambar; ?>"
                    class="img-fluid rounded"
                    style="
                        max-height:220px;
                        object-fit:contain;
                    ">

            </div>

        </div>

        <!-- DESKRIPSI -->

        <div class="col-12">

            <label class="form-label fw-semibold">

                Deskripsi Produk

            </label>

            <textarea
                name="deskripsi"
                class="form-control"
                rows="5"
                placeholder="Masukkan deskripsi produk..."><?= htmlspecialchars($data['deskripsi']); ?></textarea>

        </div>

    </div>

    <hr class="my-4">

    <div class="d-flex justify-content-end gap-2 flex-wrap">

        <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">

            <i class="bi bi-x-circle"></i>

            Batal

        </button>

        <button
            type="submit"
            name="update"
            class="btn btn-warning">

            <i class="bi bi-check-circle"></i>

            Simpan Perubahan

        </button>

    </div>

</form>

<script>

const gambarEdit = document.getElementById("gambarEdit");
const previewEdit = document.getElementById("previewEdit");

gambarEdit.addEventListener("change", function(){

    const file = this.files[0];

    if(file){

        const reader = new FileReader();

        reader.onload = function(e){

            previewEdit.src = e.target.result;

        }

        reader.readAsDataURL(file);

    }

});

</script>