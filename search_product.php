<?php
include 'koneksi.php';

header('Content-Type: application/json');

$query = isset($_GET['query']) ? mysqli_real_escape_string($koneksi, $_GET['query']) : '';

if (empty($query)) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id_barang, nama_barang, foto_barang FROM tb_barang WHERE nama_barang LIKE '%$query%' LIMIT 10";
//untuk menampilkan semua data dari tb_barang dan diurutkan berdasarkan nama_barang dengan limit 10
$result = mysqli_query($koneksi, $sql);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = [
        'id' => $row['id_barang'],
        'name' => $row['nama_barang'],
        'image' => 'assets/produk/' . $row['foto_barang']
    ];
}

echo json_encode($products);
?>
