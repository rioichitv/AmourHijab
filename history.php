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
//untuk menampilkan semua data dari tb_users
$result = mysqli_query($koneksi, $query);
if ($result && mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Riwayat Transaksi - Amour Hijab</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: #e9c7c7;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
        }
        table {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #dca7a7;
            color: white;
            font-weight: 700;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
        }
        .back-button {
            display: block;
            max-width: 900px;
            margin: 20px auto;
            text-align: center;
        }
        .back-button a {
            background-color: #dca7a7;
            color: white;
            padding: 10px 25px;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: background-color 0.3s ease;
        }
        .back-button a:hover {
            background-color: #c18a8a;
        }
        /* Status box styles */
        .status-box {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 15px;
            font-weight: 700;
            font-size: 14px;
            text-align: center;
            min-width: 130px;
            user-select: none;
            background-color: #f0d6d6;
            color: #666;
        }
        .status-menunggu-pembayaran {
            background-color: #e74c3c; /* Red */
            color: white;
            font-weight: 700;
            border-radius: 10px;
            padding: 10px 20px;
            min-width: 130px;
            text-align: center;
            user-select: none;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
            color: white;
            font-weight: 700;
            border-radius: 15px;
            padding: 6px 12px;
            min-width: 130px;
            text-align: center;
            user-select: none;
        }
    </style>
        <style>
            /* Additional styling to match user profile box style */
            body {
                background: #e9c7c7;
                font-family: 'Poppins', sans-serif;
            }
            .profile-wrapper {
                max-width: 700px;
                margin: 40px auto;
                background: #f0d6d6;
                border-radius: 15px;
                padding: 30px 40px 40px 40px;
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
            h2 {
                font-weight: 700;
                margin-bottom: 20px;
            }
            table {
                background: white;
                border-radius: 15px;
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                overflow: hidden;
            }
            th, td {
                padding: 12px 15px;
            }
            th {
                background-color: #dca7a7;
                color: white;
                font-weight: 700;
            }
            .back-button {
                margin-top: 20px;
            }
            /* Pagination button styles updated to match user image */
            .btn-pagination {
                background-color: #f7d6d6;
                color: #333;
                border: none;
                border-radius: 15px;
                padding: 8px 16px;
                font-weight: 600;
                cursor: pointer;
                transition: background-color 0.3s ease;
                margin-left: 5px;
                font-family: 'Poppins', sans-serif;
                font-size: 18px;
                box-shadow: none;
            }
            .btn-pagination:hover:not(:disabled) {
                background-color: #e0bcbc;
                color: #000;
            }
            .btn-pagination:disabled {
                background-color: #f0d6d6;
                color: #999;
                cursor: not-allowed;
            }
            .current-page {
                background-color: #dca7a7;
                color: white;
                border-radius: 15px;
                padding: 8px 16px;
                font-weight: 700;
                user-select: none;
                display: inline-flex;
                align-items: center;
                font-family: 'Poppins', sans-serif;
                font-size: 18px;
                box-shadow: none;
                margin-left: 5px;
            }
        </style>
</head>
<body>
    <h2>Riwayat Transaksi</h2>
    <div style="overflow-x: auto; max-width: 1600px; margin: 0 auto; background-color: #e9c7c7;">
        <table style="min-width: 1600px;">
            <thead style="min-width: 1600px;">
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Nama pemesan</th>
                    <th>Total harga</th>
                    <th>Status</th>
                </tr>
            </thead>
                <tbody style="min-width: 1600px; background-color: #dfadae;">
                    <?php
                    $query_transaksi = "SELECT id_pesanan, tanggal_pesanan, nama_pesanan, total_harga_pesanan, status_pesanan FROM tb_pesanan WHERE nama_pesanan = '".mysqli_real_escape_string($koneksi, $user['Nama'])."' ORDER BY tanggal_pesanan DESC";
                    //Untuk menampilkan semua data dari kolom id_pesanan, tanggal_pesanan, nama_pesanan, total_harga_pesanan, status_pesanan diurutkan berdasarkan tanggal_pesanan dari terbaru ke terlama
                    // Pagination setup
                    $limit = 5;
                    $page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
                    $offset = ($page - 1) * $limit;
                    
                    // Count total records
                    $count_query = "SELECT COUNT(*) as total FROM tb_pesanan WHERE nama_pesanan = '".mysqli_real_escape_string($koneksi, $user['Nama'])."'";
                    //untuk menghitung jumlah data di tb_pesanan yang dipilih berdasarkan nama pemesan 
                    $count_result = mysqli_query($koneksi, $count_query);
                    $total_records = 0;
                    if ($count_result && $row_count = mysqli_fetch_assoc($count_result)) {
                        $total_records = (int)$row_count['total'];
                    }
                    $total_pages = ceil($total_records / $limit);
                    
                    // Fetch limited records for current page
                    $query_transaksi = "SELECT id_pesanan, tanggal_pesanan, nama_pesanan, total_harga_pesanan, status_pesanan FROM tb_pesanan WHERE nama_pesanan = '".mysqli_real_escape_string($koneksi, $user['Nama'])."' ORDER BY tanggal_pesanan DESC LIMIT $limit OFFSET $offset";
                    //untuk menampilkan semua data dari kolom id_pesanan, tanggal_pesanan, nama_pesanan, total_harga_pesanan, status_pesanan diurutkan berdasarkan tanggal_pesanan dari terbaru ke terlama
                    $result_transaksi = mysqli_query($koneksi, $query_transaksi);
                    
                    if ($result_transaksi && mysqli_num_rows($result_transaksi) > 0) {
                        while ($row = mysqli_fetch_assoc($result_transaksi)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_pesanan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tanggal_pesanan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama_pesanan']) . "</td>";
                            echo "<td>Rp. " . number_format($row['total_harga_pesanan'], 0, ',', '.') . "</td>";
                            $status = htmlspecialchars($row['status_pesanan']);
                            $status_class = '';
                            switch (strtolower($status)) {
                                case 'menunggu pembayaran':
                                    $status_class = 'status-menunggu-pembayaran';
                                    break;
                                case 'diproses':
                                    $status_class = 'status-diproses';
                                    break;
                                case 'dikirim':
                                    $status_class = 'status-dikirim';
                                    break;
                                case 'selesai':
                                    $status_class = 'status-selesai';
                                    break;
                            }
                            echo "<td><span class='status-box $status_class'>{$status}</span></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='no-data'>Tidak ada riwayat transaksi.</td></tr>";
                    }
                    ?>
                </tbody>
        </table>
    </div>
    <div style="max-width: 900px; margin: 20px auto; display: flex; justify-content: center; gap: 10px;">
        <?php if ($total_pages > 1): ?>
            <!-- Previous arrow button -->
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="btn-pagination">«</a>
            <?php endif; ?>

            <!-- Previous page number button -->
            <?php if ($page > 1): ?>
                <a href="?page=<?= $page - 1 ?>" class="btn-pagination"><?= $page - 1 ?></a>
            <?php endif; ?>

            <!-- Current page -->
            <span class="current-page"><?= $page ?></span>

            <!-- Next page number button -->
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="btn-pagination"><?= $page + 1 ?></a>
            <?php endif; ?>

            <!-- Next arrow button -->
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?= $page + 1 ?>" class="btn-pagination">»</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="back-button">
        <a href="user_profile.php">Kembali ke Profil</a>
    </div>
</body>
</html>
