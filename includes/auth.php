<?php
session_start();

if (!isset($_SESSION['admin_login'])) {

    header("Location: login.php");
    exit;

}
?>