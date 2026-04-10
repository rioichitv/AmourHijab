    <?php
session_start();
include 'koneksi.php';

$errors = [];
$success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $nama = trim($_POST['nama'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $no_hp = trim($_POST['no_hp'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username)) {
            $errors[] = 'Username harus diisi.';
        }
        if (empty($nama)) {
            $errors[] = 'Nama harus diisi.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email tidak valid.';
        }
        if (empty($no_hp)) {
            $errors[] = 'No. Handphone harus diisi.';
        }
        if (strlen($password) < 6) {
            $errors[] = 'Kata Sandi minimal 6 karakter.';
        }

        if (empty($errors)) {
            $check_username = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE username = '".mysqli_real_escape_string($koneksi, $username)."'");
             //untuk mengecek apakah username tersebut ada di database dan untuk menghindari serangan sql injection
            $check_email = mysqli_query($koneksi, "SELECT * FROM tb_users WHERE email = '".mysqli_real_escape_string($koneksi, $email)."'");
            //untuk mengecek apakah email tersebut ada di database dan untuk menghindari serangan sql injection
            if (mysqli_num_rows($check_username) > 0) {
                $errors[] = 'Username sudah terdaftar.';
            } elseif (mysqli_num_rows($check_email) > 0) {
                $errors[] = 'Email sudah digunakan.';
            } else {
                $username_esc = mysqli_real_escape_string($koneksi, $username);
                $nama_esc = mysqli_real_escape_string($koneksi, $nama);
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $email_esc = mysqli_real_escape_string($koneksi, $email);
                $no_hp_esc = mysqli_real_escape_string($koneksi, $no_hp);

                $insert = mysqli_query($koneksi, "INSERT INTO tb_users (username, Nama, email, no_hp, password, role) VALUES ('$username_esc', '$nama_esc', '$email_esc', '$no_hp_esc', '$password_hash', 'member')");
                //untuk memasukkan data ke tb_users dalam database
                if ($insert) {
                    $success = 'Registrasi berhasil. Silakan <a href="login.php">login</a>.';
                } else {
                    $errors[] = 'Terjadi kesalahan saat menyimpan data.';
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
    <title>Daftar - Amour Hijab</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: #e9c7c7;
            margin: 0;
            padding: 0;
        }
        .register-container {
            max-width: 400px;
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
            display: inline-block;
            width: 100px;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.5px;
            margin-top: 15px;
        }
        .name-group {
            display: flex;
            gap: 12px;
            margin-top: 5px;
            margin-bottom: 10px;
        }
        .name-group input {
            width: calc(100% - 110px);
            padding: 12px 20px;
            border-radius: 25px;
            border: none;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
            color: #333;
        }
        input[type="email"],
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 110px);
            padding: 12px 20px;
            margin-top: 5px;
            border-radius: 25px;
            border: none;
            font-size: 15px;
            outline: none;
            box-sizing: border-box;
            color: #333;
            display: inline-block;
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
            width: 100px;
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
        button.reset-btn {
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
    <div class="register-container">
        <!--<img src="assets/img/amour1.png" alt="Amour Hijab Logo" class="logo" />-->
        <h2>DAFTAR</h2>
        <p class="description">Silahkan lengkapi informasi di kolom yang tersedia:</p>

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
            <input type="text" id="username" name="username" placeholder="Username" required>
            <label for="nama_depan">Nama :</label>
            <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="no_hp">WhatsApp :</label>
            <input type="text" id="no_hp" name="no_hp" placeholder="No WhatsApp" required>

            <label for="password">Kata Sandi :</label>
            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" minlength="6" required>

            <div class="btn-container">
                <button type="button" class="reset-btn" onclick="window.location.href='index.php'">Kembali</button>
                <button type="submit">Daftar</button>
            </div>
        </form>
    </div>
</body>
</html>
