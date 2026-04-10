<?php
include '../koneksi.php';
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$admin_query = mysqli_query($koneksi, "SELECT * FROM tb_admin WHERE username_admin = '".mysqli_real_escape_string($koneksi, $username)."' LIMIT 1");
//Untuk menghindari serangan SQL Injection dan memberikan keamanan dan menajaga data data di database dengan menggunakan mysqli_real_escape_string

if (mysqli_num_rows($admin_query) == 1) {
    $admin = mysqli_fetch_assoc($admin_query);
    //(mysqli_num_rows($admin_query) == 1) untuk mengecek apakah username tersebut ada di database
    // untuk mengambil data dari database
    if ($password === $admin['password_admin']) {
        $_SESSION['id_admin'] = $admin['id_admin'];
        $_SESSION['username_admin'] = $admin['username_admin'];
        // Redirect to admin dashboard
        echo '<script>alert("Login Sukses!"); document.location="index.php";</script>';
    } else {
        echo '<script>alert("Password salah."); document.location="login.php";</script>';
    }
} else {
    echo '<script>alert("Username tidak ditemukan."); document.location="login.php";</script>';
}

?>