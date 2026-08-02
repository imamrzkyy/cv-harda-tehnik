<?php
include '../config/koneksi.php';
include '../includes/header.php';
?>

<style>

body{

    background:
    linear-gradient(
        rgba(0,0,0,.35),
        rgba(0,0,0,.35)
    ),
    url("../assets/images/background/login-bg.jpg");

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    background-attachment:fixed;

}

body::before{

    content:"";

    position:fixed;

    inset:0;

    backdrop-filter:blur(4px);

    z-index:-1;

}

.register-section{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:50px 15px;
}

.register-card{
    background:#fff;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 20px 60px rgba(0,0,0,.15);
}

.register-left{

    position:relative;
    overflow:hidden;

    background:linear-gradient(
        rgba(13,71,161,.90),
        rgba(25,118,210,.90)
    );

    color:#fff;
    padding:60px;

    display:flex;
    flex-direction:column;
    justify-content:center;

}

.register-left::before{

    content:"";

    position:absolute;

    width:350px;
    height:350px;

    background:rgba(255,255,255,.08);

    border-radius:50%;

    top:-120px;
    right:-120px;

}

.register-left::after{

    content:"";

    position:absolute;

    width:220px;
    height:220px;

    background:rgba(255,255,255,.05);

    border-radius:50%;

    bottom:-70px;
    left:-70px;

}


.register-left img{

    width:130px;
    height:auto;
    margin-bottom:30px;

    background:#fff;
    padding:10px;
    border-radius:20px;

    box-shadow:0 10px 30px rgba(0,0,0,.15);

}

.register-left h2{
    color:#fff;
    font-weight:700;
}

.register-left p{
    color:rgba(255,255,255,.9);
    margin-top:20px;
    line-height:1.8;
    opacity:.9;
}

.register-right{
    padding:50px;
}

.form-control{
    height:52px;
    border-radius:12px;
}

textarea.form-control{
    height:100px;
    resize:none;
}

.input-group-text{
    background:#0d6efd;
    color:#fff;
    border:none;
}

.btn-register{
    height:55px;
    border-radius:12px;
    font-weight:600;
}

.alert{
    border-radius:12px;
}

@media(max-width:991px){

.register-left{
display:none;
}

.register-right{
padding:35px 25px;
}

}

</style>

<section class="register-section">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-11">

<div class="register-card">

<div class="row g-0">

<div class="col-lg-5 register-left">

<img src="../assets/images/logo/logo CV HD.png">

<h2>CV. HARDA TEHNIK MANDIRI</h2>

<p>

Daftarkan akun Anda untuk melakukan booking service AC,
melihat riwayat service,
dan mendapatkan informasi terbaru dari kami.

</p>

</div>

<div class="col-lg-7 register-right">

<h3 class="fw-bold text-primary mb-4 text-center">

Buat Akun Baru

</h3>

<?php
if(isset($_GET['pesan'])){

if($_GET['pesan']=="email"){
?>

<div class="alert alert-danger">

Email sudah digunakan.

</div>

<?php } ?>

<?php
if($_GET['pesan']=="sukses"){
?>

<div class="alert alert-success">

Registrasi berhasil.

</div>

<?php }} ?>

<form action="proses_register.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label>Nama Lengkap</label>

<input
type="text"
name="nama"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>No HP</label>

<input
type="text"
name="no_hp"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Password</label>

<div class="input-group">

<input
type="password"
name="password"
id="password"
class="form-control"
required>

<button
class="btn btn-outline-secondary"
type="button"
onclick="lihatPassword()">

<i class="bi bi-eye-fill"></i>

</button>

</div>

</div>

<div class="col-12 mb-4">

<label>Alamat</label>

<textarea
name="alamat"
class="form-control"></textarea>

</div>

<div class="col-12">

<button class="btn btn-primary w-100 btn-register">

<i class="bi bi-person-plus-fill"></i>

Daftar Sekarang

</button>

</div>

</div>

</form>

<div class="text-center mt-4">

Sudah punya akun?

<a href="login.php">

Masuk

</a>

</div>

<div class="text-center mt-3">

<a href="../index.php" class="btn btn-light">

<i class="bi bi-arrow-left"></i>

Kembali ke Beranda

</a>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

</section>

<script>

function lihatPassword(){

let x=document.getElementById("password");

if(x.type==="password"){

x.type="text";

}else{

x.type="password";

}

}

</script>

<?php include '../includes/footer.php'; ?>