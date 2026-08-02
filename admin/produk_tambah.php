    <?php

    include "../includes/auth.php";
    include "../config/koneksi.php";

    /* ===========================================
    SIMPAN PRODUK
    =========================================== */

    if(isset($_POST['simpan'])){

        $id_kategori = (int)$_POST['id_kategori'];

        $nama_produk = mysqli_real_escape_string($koneksi,trim($_POST['nama_produk']));

        $merk = mysqli_real_escape_string($koneksi,trim($_POST['merk']));

        $pk_ac = mysqli_real_escape_string($koneksi,trim($_POST['pk_ac']));

        $kondisi = mysqli_real_escape_string($koneksi,$_POST['kondisi']);

        $harga = str_replace(".","",$_POST['harga']);

        $stok = (int)$_POST['stok'];

        $status = mysqli_real_escape_string($koneksi,$_POST['status']);

        $deskripsi = mysqli_real_escape_string($koneksi,$_POST['deskripsi']);

        $gambar = "";

        /* ===========================
        UPLOAD GAMBAR
        =========================== */

        if($_FILES['gambar']['name']!=""){

            $folder="../uploads/produk/";

            if(!is_dir($folder)){

                mkdir($folder,0777,true);

            }

            $ext = strtolower(pathinfo($_FILES['gambar']['name'],PATHINFO_EXTENSION));

            $allow = ['jpg','jpeg','png','webp'];

            if(in_array($ext,$allow)){

                $gambar = uniqid().".".$ext;

                move_uploaded_file(

                    $_FILES['gambar']['tmp_name'],

                    $folder.$gambar

                );

            }

        }

        mysqli_query($koneksi,"

            INSERT INTO produk(
                id_kategori,
                nama_produk,
                merk,
                pk_ac,
                kondisi,
                harga,
                stok,
                deskripsi,
                gambar,
                status
            )

            VALUES(
                '$id_kategori',
                '$nama_produk',
                '$merk',
                '$pk_ac',
                '$kondisi',
                '$harga',
                '$stok',
                '$deskripsi',
                '$gambar',
                '$status'
            )

        ");

        header("Location: produk.php?success=tambah");

        exit;

    }

    $nama = $_SESSION['nama_admin'];
    $role = $_SESSION['role_admin'];

    include "header.php";
    include "sidebar.php";

    /* ===========================
    DATA KATEGORI
    =========================== */

    $kategori = mysqli_query($koneksi,"

        SELECT *

        FROM kategori_produk

        ORDER BY nama_kategori ASC

    ");

    ?>
    <div class="content">

        <div class="container-fluid">

            <!-- ===========================
                HEADER
            ============================ -->

            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

                <div>

                    <h2 class="fw-bold text-primary mb-1">

                        <i class="bi bi-plus-circle"></i>

                        Tambah Produk

                    </h2>

                    <p class="text-muted mb-0">

                        Tambahkan produk baru ke dalam sistem.

                    </p>

                </div>

                <a
                    href="produk.php"
                    class="btn btn-secondary mt-3 mt-md-0">

                    <i class="bi bi-arrow-left"></i>

                    Kembali

                </a>

            </div>

            <!-- ===========================
                FORM
            ============================ -->

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <form
                        method="POST"
                        enctype="multipart/form-data">

                        <div class="row g-4">

                            <!-- ===========================
                                KATEGORI
                            ============================ -->

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

                                    <?php while($k=mysqli_fetch_assoc($kategori)){ ?>

                                    <option value="<?= $k['id_kategori']; ?>">

                                        <?= htmlspecialchars($k['nama_kategori']); ?>

                                    </option>

                                    <?php } ?>

                                </select>

                            </div>

                            <!-- ===========================
                                NAMA PRODUK
                            ============================ -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Nama Produk

                                </label>

                                <input
                                    type="text"
                                    name="nama_produk"
                                    class="form-control"
                                    required>

                            </div>

                            <!-- ===========================
                                MERK
                            ============================ -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Merk

                                </label>

                                <input
                                    type="text"
                                    name="merk"
                                    class="form-control"
                                    required>

                            </div>

                            <!-- ===========================
                                PK AC
                            ============================ -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    PK AC

                                </label>

                                <input
                                    type="text"
                                    name="pk_ac"
                                    class="form-control"
                                    placeholder="Contoh : 1 PK"
                                    required>

                            </div>

                            <!-- ===========================
                                HARGA
                            ============================ -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Harga

                                </label>

                                <input
                                    type="number"
                                    name="harga"
                                    class="form-control"
                                    min="0"
                                    required>

                            </div>

                            <!-- ===========================
                                STOK
                            ============================ -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Stok

                                </label>

                                <input
                                    type="number"
                                    name="stok"
                                    class="form-control"
                                    min="0"
                                    value="0"
                                    required>

                            </div>

                            <!-- ===========================
                                KONDISI
                            ============================ -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Kondisi

                                </label>

                                <select
                                    name="kondisi"
                                    class="form-select"
                                    required>

                                    <option value="Baru">

                                        Baru

                                    </option>

                                    <option value="Bekas">

                                        Bekas

                                    </option>

                                </select>

                            </div>

                            <!-- ===========================
                                STATUS
                            ============================ -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Status

                                </label>

                                <select
                                    name="status"
                                    class="form-select"
                                    required>

                                    <option value="Tersedia">

                                        Tersedia

                                    </option>

                                    <option value="Habis">

                                        Habis

                                    </option>

                                </select>

                            </div>
                                                    <!-- ===========================
                                UPLOAD GAMBAR
                            ============================ -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Gambar Produk

                                </label>

                                <input
                                    type="file"
                                    name="gambar"
                                    id="gambar"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <small class="text-muted">

                                    Format: JPG, JPEG, PNG, WEBP

                                </small>

                            </div>

                            <!-- PREVIEW -->

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">

                                    Preview Gambar

                                </label>

                                <div class="border rounded p-3 text-center">

                                    <img
                                        id="preview"
                                        src="../assets/images/no-image.png"
                                        class="img-fluid rounded"
                                        style="
                                            max-height:220px;
                                            object-fit:contain;
                                        ">

                                </div>

                            </div>

                            <!-- ===========================
                                DESKRIPSI
                            ============================ -->

                            <div class="col-12">

                                <label class="form-label fw-semibold">

                                    Deskripsi Produk

                                </label>

                                <textarea
                                    name="deskripsi"
                                    class="form-control"
                                    rows="6"
                                    placeholder="Masukkan deskripsi produk..."></textarea>

                            </div>

                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2 justify-content-end flex-wrap">

                            <a
                                href="produk.php"
                                class="btn btn-secondary">

                                <i class="bi bi-arrow-left"></i>

                                Kembali

                            </a>

                            <button
                                type="reset"
                                class="btn btn-warning">

                                <i class="bi bi-arrow-clockwise"></i>

                                Reset

                            </button>

                            <button
                                type="submit"
                                name="simpan"
                                class="btn btn-primary">

                                <i class="bi bi-check-circle"></i>

                                Simpan Produk

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>

    const gambar = document.getElementById("gambar");
    const preview = document.getElementById("preview");

    gambar.addEventListener("change",function(){

        const file = this.files[0];

        if(file){

            const reader = new FileReader();

            reader.onload = function(e){

                preview.src = e.target.result;

            }

            reader.readAsDataURL(file);

        }

    });

    </script>

    <?php include "footer.php"; ?>