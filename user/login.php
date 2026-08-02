<?php include '../includes/header.php'; ?>

<style>

body{
    background:
        linear-gradient(rgba(0,0,0,.35),rgba(0,0,0,.35)),
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

.login-logo{
    width: 140px;
    height: 140px;
}

.login-section{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 15px;
}

.login-card{
    background:#fff;
    border-radius:25px;
    overflow:hidden;
    box-shadow:0 20px 60px rgba(0,0,0,.18);
    animation:fadeUp .7s ease;
}

@keyframes fadeUp{

    from{
        opacity:0;
        transform:translateY(40px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }

}

.login-left{

    position:relative;
    overflow:hidden;

    background:linear-gradient(
        rgba(13,71,161,.88),
        rgba(25,118,210,.82)
    );

    color:#fff;
    padding:60px;
    display:flex;
    flex-direction:column;
    justify-content:center;

}

.login-left::before{

    content:"";
    position:absolute;

    width:350px;
    height:350px;

    border-radius:50%;
    background:rgba(255,255,255,.08);

    top:-120px;
    right:-120px;

}

.login-left::after{

    content:"";
    position:absolute;

    width:220px;
    height:220px;

    border-radius:50%;
    background:rgba(255,255,255,.05);

    bottom:-70px;
    left:-70px;

}

.login-left>*{

    position:relative;
    z-index:2;

}

.logo{
    width:150px;
    height:auto;
    margin-bottom:30px;

    background:#fff;
    padding:10px;
    border-radius:20px;

    box-shadow:0 10px 30px rgba(0,0,0,.15);
}

.login-left h1{

    color:#fff;
    font-size:42px;
    font-weight:700;

}

.login-left p{

    color:rgba(255,255,255,.9);
    line-height:1.8;
    margin-top:20px;

}

.login-right{

    padding:60px 50px;

}

.form-control{

    height:55px;

}

.input-group-text{

    background:#0d6efd;
    color:#fff;
    border:none;

}

.btn-login{

    height:55px;
    border-radius:12px;
    font-weight:600;
    transition:.3s;

}

.btn-login:hover{

    transform:translateY(-2px);

    box-shadow:0 10px 25px rgba(13,110,253,.30);

}

.link-register{

    text-decoration:none;
    font-weight:600;

}

.link-register:hover{

    text-decoration:underline;

}

@media(max-width:991px){

    .login-left{
        display:none;
    }

    .login-right{
        padding:40px 25px;
    }

}

</style>

<section class="login-section">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-10">
<div class="login-card">
<div class="row g-0">
<div class="col-lg-6 login-left">
<img src="../assets/images/logo/logo CV HD.png" class="logo">
<h1>Selamat Datang</h1>

<p>

Silakan login untuk melakukan booking service AC,
melihat status booking,
mengelola akun,
dan menikmati layanan CV. Harda Tehnik Mandiri.

</p>

</div>

<div class="col-lg-6 login-right">

<div class="text-center mb-4">

<h2 class="fw-bold text-primary">
Login Akun
</h2>

<p class="text-muted">

CV. HARDA TEHNIK MANDIRI

</p>

</div>

<?php

if(isset($_GET['pesan'])){

    if($_GET['pesan']=="email"){
        echo '<div class="alert alert-danger">Email tidak terdaftar.</div>';
    }

    if($_GET['pesan']=="password"){
        echo '<div class="alert alert-danger">Password salah.</div>';
    }

    if($_GET['pesan']=="nonaktif"){
        echo '<div class="alert alert-warning">Akun belum aktif.</div>';
    }

}

?>

<form action="proses_login.php" method="POST">

<div class="mb-3">

<label class="form-label">

Email

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-envelope-fill"></i>

</span>

<input
type="email"
name="email"
class="form-control"
placeholder="Masukkan Email"
required>

</div>

</div>

<div class="mb-2">

<label class="form-label">

Password

</label>

<div class="input-group">

<span class="input-group-text">

<i class="bi bi-lock-fill"></i>

</span>

<input
type="password"
id="password"
name="password"
class="form-control"
placeholder="Masukkan Password"
required>

<button
class="btn btn-outline-secondary"
type="button"
onclick="showPassword()">

<i id="eyeIcon" class="bi bi-eye-fill"></i>

</button>

</div>

</div>

<div class="text-end mb-4">

<a href="#" class="text-decoration-none">

Lupa Password?

</a>

</div>

<button class="btn btn-primary w-100 btn-login">

<i class="bi bi-box-arrow-in-right"></i>

Masuk

</button>

<div class="text-center mt-4">

Belum punya akun?

<a href="register.php" class="link-register">

Daftar Sekarang

</a>

</div>

<div class="text-center mt-3">

<a href="../index.php" class="btn btn-light">

<i class="bi bi-arrow-left"></i>

Kembali ke Beranda

</a>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

</div>

</section>

<script>

function showPassword(){

    let password=document.getElementById("password");
    let eye=document.getElementById("eyeIcon");

    if(password.type==="password"){

        password.type="text";

        eye.classList.remove("bi-eye-fill");
        eye.classList.add("bi-eye-slash-fill");

    }else{

        password.type="password";

        eye.classList.remove("bi-eye-slash-fill");
        eye.classList.add("bi-eye-fill");

    }

}

</script>

<?php include '../includes/footer.php'; ?>