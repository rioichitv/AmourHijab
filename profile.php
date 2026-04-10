<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'member') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id_user'];
$errors = [];
$success = '';

// Fetch current user data
$query = "SELECT * FROM tb_users WHERE id_user = $user_id LIMIT 1";
//untuk menampilkan semua data dari tb_users
$result = mysqli_query($koneksi, $query);
if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    // User not found, logout
    session_destroy();
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';

    if (empty($nama)) {
        $errors[] = 'Nama harus diisi.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email tidak valid.';
    }
    if (empty($no_hp)) {
        $errors[] = 'No. Handphone harus diisi.';
    }
    if (!empty($password)) {
        if (strlen($password) < 6) {
            $errors[] = 'Kata Sandi minimal 6 karakter.';
        }
        if ($password !== $password_confirm) {
            $errors[] = 'Konfirmasi kata sandi tidak cocok.';
        }
    }

    if (empty($errors)) {
        $nama_esc = mysqli_real_escape_string($koneksi, $nama);
        $email_esc = mysqli_real_escape_string($koneksi, $email);
        $no_hp_esc = mysqli_real_escape_string($koneksi, $no_hp);

        // Check if email is used by another user
        $check_email_query = "SELECT * FROM tb_users WHERE email = '$email_esc' AND id_user != $user_id";
        //untuk menampilkan semua data dari tb_users
        $check_email_result = mysqli_query($koneksi, $check_email_query);
        if ($check_email_result && mysqli_num_rows($check_email_result) > 0) {
            $errors[] = 'Email sudah digunakan oleh pengguna lain.';
        } else {
            if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $update_query = "UPDATE tb_users SET Nama = '$nama_esc', email = '$email_esc', no_hp = '$no_hp_esc', password = '$password_hash' WHERE id_user = $user_id";
                //UPDATE untuk memperbarui data dari tb_users dengan data baru
            } else {
                $update_query = "UPDATE tb_users SET Nama = '$nama_esc', email = '$email_esc', no_hp = '$no_hp_esc' WHERE id_user = $user_id";
            }
            $update_result = mysqli_query($koneksi, $update_query);
            if ($update_result) {
                $success = 'Profil berhasil diperbarui.';
                // Refresh user data
                $result = mysqli_query($koneksi, $query);
                $user = mysqli_fetch_assoc($result);
                $_SESSION['user_name'] = $user['Nama'];
            } else {
                $errors[] = 'Terjadi kesalahan saat memperbarui profil.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil - Amour Hijab</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: #e9c7c7;
            margin: 0;
            padding: 0;
        }
        .profile-container {
            max-width: 500px;
            margin: 80px auto;
            background: #dca7a7;
            padding: 30px 40px 40px 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            color: white;
            position: relative;
        }
        h2 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 4px;
            font-size: 28px;
        }
        p.description {
            text-align: center;
            font-size: 14px;
            margin-bottom: 25px;
            font-weight: 400;
            letter-spacing: 0.5px;
        }
        label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.5px;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
            color: #333;
            display: block;
        }
        input::placeholder {
            color: #999;
            opacity: 1;
            padding-left: 15px;
        }
        .btn-container {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }
        button {
            width: 120px;
            background: #b86b6b;
            color: white;
            border: none;
            padding: 12px 0;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 6px 10px rgba(0,0,0,0.2);
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #a05a5a;
        }
        .error-messages {
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>PROFIL</h2>
        <p class="description">Perbarui informasi profil Anda:</p>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-message"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Username :</label>
            <input type="text" id="username" name="username" placeholder="Username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" readonly disabled>
            <small style="color: red;">Username tidak dapat di ubah</small>

            <label for="nama">Nama :</label>
            <input type="text" id="nama" name="nama" placeholder="Nama" value="<?= htmlspecialchars($user['Nama']) ?>" readonly onclick="return false;">
            <small style="color: red;">Nama tidak dapat di ubah</small>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="Email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label for="no_hp">No. Handphone :</label>
            <input type="text" id="no_hp" name="no_hp" placeholder="No. Handphone" value="<?= htmlspecialchars($user['no_hp']) ?>" required>

            <label for="password">Kata Sandi Baru (kosongkan jika tidak ingin mengubah) :</label>
            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter">

            <label for="password_confirm">Konfirmasi Kata Sandi :</label>
            <input type="password" id="password_confirm" name="password_confirm" placeholder="Konfirmasi Kata Sandi">

            <div class="btn-container">
                <button type="button" onclick="window.location.href='index.php'">Kembali</button>
                <button type="submit">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
