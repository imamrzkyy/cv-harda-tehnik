<?php
session_start();

include "../config/koneksi.php";

$pesan = "";
$tipe_pesan = "";

/*====================================
=           CRUD GALERI
=====================================*/

// Tambah / Edit Galeri
if(isset($_POST['simpan_galeri'])){

    $id_galeri = $_POST['id_galeri'];
    $judul = mysqli_real_escape_string($koneksi,$_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi,$_POST['deskripsi']);

    $gambar_lama = $_POST['gambar_lama'];

    if($_FILES['gambar']['name']!=""){

        $nama_file = time()."_".basename($_FILES['gambar']['name']);

        move_uploaded_file(
            $_FILES['gambar']['tmp_name'],
            "../assets/images/galeri/".$nama_file
        );

        if(
            $gambar_lama!="" &&
            file_exists("../assets/images/galeri/".$gambar_lama)
        ){
            unlink("../assets/images/galeri/".$gambar_lama);
        }

    }else{

        $nama_file = $gambar_lama;

    }

    if($id_galeri==""){

        $simpan = mysqli_query($koneksi,"
            INSERT INTO galeri
            (
                judul,
                gambar,
                deskripsi
            )
            VALUES
            (
                '$judul',
                '$nama_file',
                '$deskripsi'
            )
        ");

    }else{

        $simpan = mysqli_query($koneksi,"
            UPDATE galeri
            SET
                judul='$judul',
                gambar='$nama_file',
                deskripsi='$deskripsi'
            WHERE id_galeri='$id_galeri'
        ");

    }

    if($simpan){

        header("Location:kategori.php?galeri=sukses");
        exit;

    }

}



// Hapus Galeri
if(isset($_GET['hapus_galeri'])){

    $id = (int)$_GET['hapus_galeri'];

    $cek = mysqli_query($koneksi,"
        SELECT gambar
        FROM galeri
        WHERE id_galeri='$id'
    ");

    $data = mysqli_fetch_assoc($cek);

    if($data){

        if(
            $data['gambar']!=""
            &&
            file_exists("../assets/images/galeri/".$data['gambar'])
        ){

            unlink("../assets/images/galeri/".$data['gambar']);

        }

    }

    mysqli_query(
        $koneksi,
        "DELETE FROM galeri
         WHERE id_galeri='$id'"
    );

    header("Location:kategori.php?hapus=sukses");
    exit;

}


/*====================================
=      CRUD KATEGORI PRODUK
=====================================*/

if(isset($_POST['simpan_produk'])){

    $id = $_POST['id_kategori_produk'];
    $nama = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_kategori']
    );

    if($id==""){

        mysqli_query($koneksi,"
            INSERT INTO kategori_produk
            (
                nama_kategori
            )
            VALUES
            (
                '$nama'
            )
        ");

    }else{

        mysqli_query($koneksi,"
            UPDATE kategori_produk
            SET
                nama_kategori='$nama'
            WHERE id_kategori='$id'
        ");

    }

    header("Location:kategori.php");
    exit;

}



// Hapus Produk
if(isset($_GET['hapus_produk'])){

    $id=(int)$_GET['hapus_produk'];

    mysqli_query(
        $koneksi,
        "DELETE FROM kategori_produk
         WHERE id_kategori='$id'"
    );

    header("Location:kategori.php");
    exit;

}

/*====================================
=         AMBIL DATA
=====================================*/

$result_galeri = mysqli_query(
    $koneksi,
    "SELECT *
     FROM galeri
     ORDER BY id_galeri DESC"
);

$result_produk = mysqli_query(
    $koneksi,
    "SELECT *
     FROM kategori_produk
     ORDER BY id_kategori DESC"
);



include "header.php";
include "sidebar.php";
?>

<main class="content py-4">
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="fw-bold">
                <i class="bi bi-images me-2"></i>
                Kelola Galeri
            </h2>

            <p class="text-muted">
                Tambah, ubah, dan hapus galeri website.
            </p>
        </div>
    </div>

    <?php if(isset($_GET['galeri'])){ ?>
        <div class="alert alert-success">
            Data galeri berhasil disimpan.
        </div>
    <?php } ?>

    <?php if(isset($_GET['hapus'])){ ?>
        <div class="alert alert-success">
            Data galeri berhasil dihapus.
        </div>
    <?php } ?>

    <div class="card shadow border-0 rounded-4 mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i>
                Tambah / Edit Galeri
            </h5>
        </div>
        <div class="card-body">
            <form method="POST"
                  enctype="multipart/form-data">
                <input
                    type="hidden"
                    name="id_galeri"
                    id="id_galeri">
                <input
                    type="hidden"
                    name="gambar_lama"
                    id="gambar_lama">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Judul
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            name="judul"
                            id="judul"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Upload Gambar
                        </label>
                        <input
                            type="file"
                            class="form-control"
                            name="gambar"
                            id="gambar"
                            accept="image/*">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">
                            Deskripsi
                        </label>
                        <textarea
                            class="form-control"
                            rows="4"
                            name="deskripsi"
                            id="deskripsi"></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <img
                            src=""
                            id="preview"
                            style="display:none;
                                   max-width:250px;
                                   border-radius:10px;
                                   border:1px solid #ddd;">
                    </div>
                </div>

                <button
                    class="btn btn-primary"
                    type="submit"
                    name="simpan_galeri">
                    <i class="bi bi-save"></i>
                    Simpan Galeri
                </button>

                <button
                    type="button"
                    onclick="resetForm()"
                    class="btn btn-secondary">
                    Reset
                </button>
            </form>
        </div>
    </div>

    <!-- ==========================
     TABEL GALERI
=========================== -->

<div class="card shadow border-0 rounded-4 mb-5">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">

            <i class="bi bi-images me-2"></i>

            Data Galeri

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">No</th>

                        <th width="120">Foto</th>

                        <th>Judul</th>

                        <th>Deskripsi</th>

                        <th width="170" class="text-center">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                <?php

                $no=1;

                while($galeri=mysqli_fetch_assoc($result_galeri)){

                ?>

                    <tr>

                        <td><?= $no++; ?></td>

                        <td>

                            <?php if($galeri['gambar']!=""){ ?>

                                <img

                                    src="../assets/images/galeri/<?= $galeri['gambar']; ?>"

                                    style="width:90px;height:70px;object-fit:cover;border-radius:10px;">

                            <?php } ?>

                        </td>

                        <td>

                            <strong>

                                <?= htmlspecialchars($galeri['judul']); ?>

                            </strong>

                        </td>

                        <td>

                            <?= nl2br(htmlspecialchars($galeri['deskripsi'])); ?>

                        </td>

                        <td class="text-center">

                            <button

                                class="btn btn-warning btn-sm"

                                onclick="editGaleri(

                                '<?= $galeri['id_galeri']; ?>',

                                '<?= htmlspecialchars(addslashes($galeri['judul'])); ?>',

                                '<?= htmlspecialchars(addslashes($galeri['deskripsi'])); ?>',

                                '<?= $galeri['gambar']; ?>'

                                )">

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <a

                                href="?hapus_galeri=<?= $galeri['id_galeri']; ?>"

                                class="btn btn-danger btn-sm"

                                onclick="return confirm('Hapus gambar ini?')">

                                <i class="bi bi-trash"></i>

                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
<!-- ===========================================
     KATEGORI PRODUK
=========================================== -->

<div class="card shadow border-0 rounded-4 mb-5">

    <div class="card-header bg-success text-white">

        <h5 class="mb-0">

            <i class="bi bi-box-seam me-2"></i>

            Kelola Kategori Produk

        </h5>

    </div>

    <div class="card-body">

        <!-- FORM -->

        <form method="POST" class="row g-3 mb-4">

            <input
                type="hidden"
                name="id_kategori_produk"
                id="id_produk">

            <div class="col-md-8">

                <label class="form-label fw-semibold">

                    Nama Kategori

                </label>

                <input

                    type="text"

                    class="form-control"

                    name="nama_kategori"

                    id="nama_produk"

                    placeholder="Masukkan nama kategori..."

                    required>

            </div>

            <div class="col-md-4 d-flex align-items-end">

                <button

                    class="btn btn-success me-2"

                    type="submit"

                    name="simpan_produk">

                    <i class="bi bi-save"></i>

                    Simpan

                </button>

                <button

                    type="button"

                    onclick="resetProduk()"

                    class="btn btn-secondary">

                    Reset

                </button>

            </div>

        </form>

        <!-- TABEL -->

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="70">

                            No

                        </th>

                        <th>

                            Nama Kategori

                        </th>

                        <th width="170" class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php

                $no=1;

                while($produk=mysqli_fetch_assoc($result_produk)){

                ?>

                    <tr>

                        <td>

                            <?= $no++; ?>

                        </td>

                        <td>

                            <?= htmlspecialchars($produk['nama_kategori']); ?>

                        </td>

                        <td class="text-center">

                            <button

                                class="btn btn-warning btn-sm"

                                onclick="editProduk(

                                '<?= $produk['id_kategori']; ?>',

                                '<?= htmlspecialchars(addslashes($produk['nama_kategori'])); ?>'

                                )">

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <a

                                href="?hapus_produk=<?= $produk['id_kategori']; ?>"

                                class="btn btn-danger btn-sm"

                                onclick="return confirm('Hapus kategori ini?')">

                                <i class="bi bi-trash"></i>

                            </a>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// Preview gambar ketika dipilih
document.getElementById("gambar").addEventListener("change",function(e){

    if(e.target.files.length>0){

        let reader=new FileReader();

        reader.onload=function(x){

            let img=document.getElementById("preview");

            img.src=x.target.result;

            img.style.display="block";

        }

        reader.readAsDataURL(e.target.files[0]);

    }

});

// Konfirmasi hapus galeri
document.querySelectorAll("a[href*='hapus_galeri']").forEach(function(btn){

    btn.addEventListener("click",function(e){

        e.preventDefault();

        let url=this.href;

        Swal.fire({

            title:"Hapus galeri?",

            text:"Data tidak dapat dikembalikan.",

            icon:"warning",

            showCancelButton:true,

            confirmButtonColor:"#dc3545",

            cancelButtonColor:"#6c757d",

            confirmButtonText:"Ya, Hapus",

            cancelButtonText:"Batal"

        }).then((result)=>{

            if(result.isConfirmed){

                window.location=url;

            }

        });

    });

});

// Konfirmasi hapus kategori produk
document.querySelectorAll("a[href*='hapus_produk']").forEach(function(btn){

    btn.addEventListener("click",function(e){

        e.preventDefault();

        let url=this.href;

        Swal.fire({

            title:"Hapus kategori?",

            icon:"warning",

            showCancelButton:true,

            confirmButtonColor:"#dc3545",

            cancelButtonColor:"#6c757d",

            confirmButtonText:"Ya",

            cancelButtonText:"Batal"

        }).then((result)=>{

            if(result.isConfirmed){

                window.location=url;

            }

        });

    });

});

</script>

<script>

function editGaleri(id,judul,deskripsi,gambar){

    document.getElementById("id_galeri").value=id;

    document.getElementById("judul").value=judul;

    document.getElementById("deskripsi").value=deskripsi;

    document.getElementById("gambar_lama").value=gambar;

    let img=document.getElementById("preview");

    img.src="../assets/images/galeri/"+gambar;

    img.style.display="block";

    window.scrollTo({

        top:0,

        behavior:"smooth"

    });

}

function resetForm(){

    document.getElementById("id_galeri").value="";

    document.getElementById("judul").value="";

    document.getElementById("deskripsi").value="";

    document.getElementById("gambar_lama").value="";

    document.getElementById("gambar").value="";

    document.getElementById("preview").style.display="none";

}

function editProduk(id,nama){

    document.getElementById("id_produk").value=id;

    document.getElementById("nama_produk").value=nama;

    window.scrollTo({
        top:document.body.scrollHeight,
        behavior:"smooth"
    });

}

function resetProduk(){

    document.getElementById("id_produk").value="";

    document.getElementById("nama_produk").value="";

}

document.getElementById("gambar").addEventListener("change",function(e){

    if(e.target.files.length>0){

        let reader=new FileReader();

        reader.onload=function(x){

            let img=document.getElementById("preview");

            img.src=x.target.result;

            img.style.display="block";

        }

        reader.readAsDataURL(e.target.files[0]);

    }

});

</script>


<style>

.card{

    border:none;

    border-radius:18px;

}

.card-header{

    border-radius:18px 18px 0 0 !important;

}

.table td{

    vertical-align:middle;

}

.table img{

    transition:.3s;

}

.table img:hover{

    transform:scale(1.1);

}

.btn{

    border-radius:10px;

}

textarea{

    resize:none;

}

#preview{

    max-width:220px;

    max-height:170px;

    border-radius:12px;

    border:1px solid #ddd;

    padding:4px;

    background:#fff;

}

@media(max-width:768px){

    .content{

        padding:15px;

    }

    .card-body{

        padding:18px;

    }

    .btn{

        margin-bottom:5px;

    }

    table{

        font-size:13px;

    }

}

</style>

</main>

<?php include "footer.php"; ?>