<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo '<script>alert("Username dan password harus diisi."); window.location="login.php";</script>';
        exit;
    }

    $query = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE username = '".mysqli_real_escape_string($koneksi, $username)."' AND role = 'member' LIMIT 1");
    //untuk menghindari serangan SQL Injection dan memberikan keamanan dan menajaga data data di database dengan menggunakan mysqli_real_escape_string
    if (mysqli_num_rows($query) == 1) {
        $user = mysqli_fetch_assoc($query);
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            echo '<script>alert("Login sukses!"); window.location="index.php";</script>';
            exit;
        } else {
            echo '<script>alert("Password salah."); window.location="login.php";</script>';
            exit;
        }
    } else {
        echo '<script>alert("Username tidak ditemukan."); window.location="login.php";</script>';
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>
