<?php
session_start();

include "../config/koneksi.php";

// Jika sudah login
if (isset($_SESSION['admin_login'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {

    $email    = mysqli_real_escape_string($koneksi, trim($_POST['email']));
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "
        SELECT *
        FROM admin
        WHERE email='$email'
        LIMIT 1
    ");

    if (mysqli_num_rows($query) == 1) {

        $admin = mysqli_fetch_assoc($query);

        if (password_verify($password, $admin['password'])) {

            $_SESSION['admin_login'] = true;
            $_SESSION['id_admin']    = $admin['id_admin'];
            $_SESSION['nama_admin']  = $admin['nama'];
            $_SESSION['email_admin'] = $admin['email'];
            $_SESSION['role_admin']  = $admin['role'];
            $_SESSION['foto_admin']  = $admin['foto'];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Password yang Anda masukkan salah.";

        }

    } else {

        $error = "Email tidak ditemukan.";

    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Login Admin | CV. Harda Tehnik Mandiri</title>

    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icon -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- SweetAlert2 -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        body{

            background:#f5f7fb;
            min-height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            font-family:Segoe UI,Tahoma,Geneva,Verdana,sans-serif;

        }

        .login-card{

            width:100%;
            max-width:450px;

            background:#fff;

            border-radius:20px;

            padding:40px;

            box-shadow:0 15px 35px rgba(0,0,0,.08);

        }

        .logo{

            width:90px;

            display:block;

            margin:auto;

            margin-bottom:20px;

        }

        .title{

            text-align:center;

            font-size:28px;

            font-weight:700;

            color:#0d6efd;

            margin-bottom:5px;

        }

        .subtitle{

            text-align:center;

            color:#777;

            margin-bottom:35px;

        }

        .form-control{

            height:52px;

            border-radius:12px;

        }

        .input-group-text{

            border-radius:0 12px 12px 0;

            cursor:pointer;

        }

        .btn-login{

            height:52px;

            border-radius:12px;

            font-weight:600;

        }

        .copyright{

            text-align:center;

            margin-top:25px;

            font-size:14px;

            color:#888;

        }

    </style>

</head>

<body>

<div class="login-card">

    <img
        src="../assets/images/logo/logo CV HD.png"
        class="logo"
        alt="Logo">

    <h2 class="title">

        Login Admin

    </h2>

    <p class="subtitle">

        CV. Harda Tehnik Mandiri

    </p>

    <form method="POST">
                <!-- Email -->

        <div class="mb-3">

            <label class="form-label fw-semibold">

                Email

            </label>

            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Masukkan email admin"
                required>

        </div>

        <!-- Password -->

        <div class="mb-4">

            <label class="form-label fw-semibold">

                Password

            </label>

            <div class="input-group">

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required>

                <span
                    class="input-group-text"
                    id="togglePassword">

                    <i
                        class="bi bi-eye"
                        id="iconPassword">
                    </i>

                </span>

            </div>

        </div>

        <button
            type="submit"
            name="login"
            class="btn btn-primary btn-login w-100">

            <i class="bi bi-box-arrow-in-right"></i>

            Login

        </button>

    </form>

    <div class="copyright">

        © <?= date('Y'); ?>

        CV. Harda Tehnik Mandiri

    </div>

</div>

<?php if($error != ""){ ?>

<script>

Swal.fire({

    icon:'error',

    title:'Login Gagal',

    text:'<?= $error; ?>',

    confirmButtonColor:'#0d6efd'

});

</script>

<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

const togglePassword = document.getElementById("togglePassword");
const password = document.getElementById("password");
const icon = document.getElementById("iconPassword");

togglePassword.addEventListener("click", function(){

    if(password.type === "password"){

        password.type = "text";

        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");

    }else{

        password.type = "password";

        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");

    }

});

</script>

</body>

</html>