<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'member') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id_user'];

// Fetch user data
$query = "SELECT * FROM tb_users WHERE id_user = $user_id LIMIT 1";
//select semua data dari tb_users
$result = mysqli_query($koneksi, $query);
if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Mask password for display
$masked_password = str_repeat('*', 12);

// Extract first and last name from 'Nama' field assuming format "First Last"
$full_name = trim($user['Nama']);
$name_parts = explode(' ', $full_name, 2);
$first_name = $name_parts[0] ?? '';
$last_name = $name_parts[1] ?? '';

function getInitial($name) {
    return strtoupper(substr($name, 0, 1));
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Halaman Profil - Amour Hijab</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: #e9c7c7;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #dca7a7;
            padding: 10px 0 30px 0;
            text-align: center;
            font-weight: 700;
            font-size: 24px;
            letter-spacing: 4px;
            color: black;
            position: relative;
            font-family: 'Poppins', sans-serif;
        }
        .header .back-button {
            position: absolute;
            left: 20px;
            top: 15px;
            font-size: 24px;
            color: black;
            cursor: pointer;
            text-decoration: none;
        }
        .header-logo {
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .profile-wrapper {
            max-width: 700px;
            margin: 0 auto;
            background: #f0d6d6;
            border-radius: 15px;
            padding: 30px 40px 40px 40px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            display: flex;
            gap: 40px;
            align-items: flex-start;
            margin-top: 20px;
            position: relative;
        }
        .profile-pic-container {
            flex-shrink: 0;
            text-align: center;
            margin-left: 0;
            position: absolute;
            left: -140px;
            top: 50%;
            transform: translateY(-50%);
        }
        .profile-pic-circle {
            width: 100px;
            height: 100px;
            background-color: #dca7a7;
            border-radius: 50%;
            font-size: 48px;
            color: white;
            line-height: 100px;
            font-weight: 700;
            margin: 0 auto 10px auto;
            user-select: none;
        }
        .change-photo-btn {
            background-color: #dca7a7;
            border: none;
            border-radius: 15px;
            padding: 6px 12px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .profile-info {
            flex-grow: 1;
            background: transparent;
            border-radius: 15px;
            padding: 30px 40px;
            font-size: 16px;
            color: #333;
            line-height: 1.8;
            box-sizing: border-box;
            box-shadow: none;
        }
        .profile-info strong {
            display: inline-block;
            width: 140px;
        }
        .profile-info p {
            margin: 10px 0;
        }
        .welcome-msg {
            font-weight: 700;
            margin-bottom: 20px;
        }
        .buttons-container {
            margin-top: 30px;
            display: flex;
            gap: 20px;
            justify-content: flex-end;
        }
        .btn {
            background-color: #dca7a7;
            border: none;
            border-radius: 15px;
            padding: 10px 25px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-decoration: none;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s ease;
        }
        .btn.logout, .btn.edit {
            background-color: #dca7a7;
            color: white;
            margin-left: 10px;
            padding: 10px 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .btn.logout:hover, .btn.edit:hover {
            background-color: #c18a8a;
        }
        .buttons-container {
            justify-content: center;
            margin-top: 20px;
            margin-right: 0;
        }
        table thead th {
            background-color: #dca7a7;
            color: white;
            padding: 6px 12px;
            border-radius: 15px 15px 0 0;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            /* Removed black border */
            /* border: 1px solid black; */
            min-width: 100px;
            user-select: none;
        }
        table tbody tr, table tbody td {
            background-color: #f7d6d6;
            color: #333;
            padding: 6px 12px;
            border-radius: 0 0 15px 15px;
            box-shadow: none;
            text-align: center;
            vertical-align: middle;
            margin: 0;
            /* Removed black border */
            /* border: 1px solid black; */
        }
        .status-box {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }
        .status-menunggu-pembayaran {
            background-color: #e74c3c; /* Red */
        }
        .status-dikirim {
            background-color: #3498db; /* Blue */
        }
        .status-diproses {
            background-color: #f1c40f; /* Yellow */
            color: black;
        }
        .status-selesai {
            background-color: #2ecc71; /* Green */
        }
      
        
    </style>
    <style>
        /* Hamburger menu styles */
        #mobileMenuBtn {
            display: none;
            position: fixed;
            top: 15px;
            right: 15px;
            width: 30px;
            height: 25px;
            cursor: pointer;
            z-index: 1100;
            flex-direction: column;
            justify-content: space-between;
        }
        #mobileMenuBtn span {
            display: block;
            height: 4px;
            background-color: #5a0a0a;
            border-radius: 2px;
        }
        #mobileMenu {
            display: none;
            position: fixed;
            top: 55px;
            right: 15px;
            background-color: #dca7a7;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            padding: 10px;
            z-index: 1099;
            width: 150px;
        }
        #mobileMenu a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.3);
        }
        #mobileMenu a:last-child {
            border-bottom: none;
        }
        #mobileMenu a:hover {
            background-color: #c18a8a;
        }
        @media (max-width: 768px) {
            #mobileMenuBtn {
                display: flex;
            }
            .profile-pic-container, .change-photo-btn, .profile-info {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php" class="back-button">&#8592;</a>
        AMOUR<br>HALAMAN PROFIL
    </div>
    <div class="header-logo" style="text-align: center; margin-top: 10px; margin-bottom: 20px;">
        <div class="profile-pic-circle" style="width: 100px; height: 100px; font-size: 48px; line-height: 100px; background-color: #dca7a7; border-radius: 50%; color: white; font-weight: 700; user-select: none; margin: 0 auto;"><?= getInitial($first_name) ?></div>
    </div>

    <div id="mobileMenuBtn" aria-label="Toggle menu" role="button" tabindex="0">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div id="mobileMenu" role="menu" aria-hidden="true">
        <a href="profile.php" role="menuitem">Ubah Profil</a>
        <a href="history.php" role="menuitem">Cek Transaksi</a>
        <a href="logout.php" role="menuitem">Logout</a>
    </div>

        <div class="profile-wrapper">
            <div class="profile-pic-container">

               <!--< <button class="change-photo-btn" onclick="alert('Fitur ubah foto belum tersedia')">Ubah Foto</button>
                <br><br> -->
                <button id="backToProfileBtn" class="change-photo-btn" style="display: inline-block; margin-top: 10px;"onclick="window.location.href='profile.php'">Ubah Profil</button>
                <br><br>
                <button id="backToProfileBtn" class="change-photo-btn" style="display: inline-block; margin-top: 10px;"onclick="window.location.href='history.php'">Cek Transaksi</button>
                <br><br>
                <button id="backToProfileBtn" class="change-photo-btn" style="display: inline-block; margin-top: 10px;"onclick="window.location.href='logout.php'">Logout</button>
                <br><br>
               
            </div>
            <div id="profileInfo" class="profile-info">
                <div class="welcome-msg">Selamat datang, <?= $first_name ?>!</div>
                <div class="info-box">
                    <p><strong class="label">Username :</strong> <span class="info-value"><?= htmlspecialchars($user['username'] ?? '') ?></span></p>
                    <p><strong class="label">Nama :</strong> <span class="info-value" style="font-family: 'Poppins', sans-serif;"><?= htmlspecialchars($user['Nama']) ?></span></p>
                    <p><strong class="label">Email :</strong> <span class="info-value"><?= $user['email'] ?></span></p>
                    <p><strong class="label">WhatsApp :</strong> <span class="info-value"><?= $user['no_hp'] ?></span></p>
                </div>
            </div>

            </div>
        </div>

    </div>

    <script>
    const profileInfo = document.getElementById('profileInfo');
    const transactionHistory = document.getElementById('transactionHistory');

    const profileBtn = document.getElementById('profileBtn');
    const dropdownMenu = document.getElementById('dropdownMenu');

    profileBtn && profileBtn.addEventListener('click', () => {
        if (dropdownMenu.style.display === 'block') {
            dropdownMenu.style.display = 'none';
        } else {
            dropdownMenu.style.display = 'block';
        }
    });

    // Close dropdown if clicked outside
    window.addEventListener('click', (event) => {
        if (!profileBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.style.display = 'none';
        }
    });

    const toggleProfileBtn = document.getElementById('toggleProfileBtn');
    const backToProfileBtn = document.getElementById('backToProfileBtn');

    toggleProfileBtn && toggleProfileBtn.addEventListener('click', () => {
        // Keep both buttons visible
        toggleProfileBtn.style.display = 'inline-block';
        backToProfileBtn.style.display = 'inline-block';
    });

    backToProfileBtn && backToProfileBtn.addEventListener('click', () => {
        // Show profile info, hide transaction history
        profileInfo.style.display = 'block';
        transactionHistory.style.display = 'none';
        // Keep both buttons visible
        toggleProfileBtn.style.display = 'inline-block';
        backToProfileBtn.style.display = 'inline-block';
    });

    // Initialize button visibility and sections
    if(toggleProfileBtn) toggleProfileBtn.style.display = 'inline-block';
    if(backToProfileBtn) backToProfileBtn.style.display = 'inline-block';
    profileInfo.style.display = 'block';
    transactionHistory.style.display = 'none';
    </script>
    <script>
        // Toggle mobile menu visibility
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        function toggleMobileMenu() {
            if (mobileMenu.style.display === 'block') {
                mobileMenu.style.display = 'none';
                mobileMenu.setAttribute('aria-hidden', 'true');
            } else {
                mobileMenu.style.display = 'block';
                mobileMenu.setAttribute('aria-hidden', 'false');
            }
        }

        mobileMenuBtn.addEventListener('click', toggleMobileMenu);

        // Keyboard accessibility: toggle menu on Enter or Space key
        mobileMenuBtn.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                toggleMobileMenu();
            }
        });

        // Close mobile menu if clicked outside
        window.addEventListener('click', (event) => {
            if (!mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                mobileMenu.style.display = 'none';
                mobileMenu.setAttribute('aria-hidden', 'true');
            }
        });
    </script>
</body>
</html>
