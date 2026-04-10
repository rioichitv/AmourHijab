<?php
include 'function.php';
include 'koneksi.php';
session_start();

$recaptchaSecretKey = '6Le-XVwrAAAAAN37sOy8JpGZWgYH7P441AUSGNeP';
$recaptchaResponse  = $_POST['g-recaptcha-response'];
$remoteIp           = $_SERVER['REMOTE_ADDR'];

$url  = "https://www.google.com/recaptcha/api/siteverify";
$data = array(
	'secret'   => $recaptchaSecretKey,
	'response' => $recaptchaResponse,
	'remoteip' => $remoteIp
);

$options = array(
	'http' => array(
		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
		'method'  => 'POST',
		'content' => http_build_query($data),
	),
);

$context  = stream_context_create($options);
$result   = file_get_contents($url, false, $context);
$response = json_decode($result, true);

if (!$response['success']) {
	echo '<script>alert("Captcha tidak tepat!"); document.location="checkout.php";</script>';
	return;
}

$cart       = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cart_total = $_SESSION['cart_total'];

if (count($cart) == 0 || $cart_total == null) {
	return header('location: cart.php');
}

date_default_timezone_set('Asia/Jakarta');

$nama_pesanan        = $_POST['nama_pesanan'];
$alamat_pesanan      = $_POST['alamat_pesanan'];
$no_hp_pesanan       = $_POST['no_hp_pesanan'];
$email_pesanan       = $_POST['email_pesanan'];
$jenis_pembayaran    = $_POST['jenis_pembayaran'];
$tanggal_pesanan     = date("Y-m-d");
$id_pesanan          = generateUniqueCode();
$total_harga_pesanan = $cart_total < 100000 ? $cart_total + 10000 : $cart_total;

mysqli_autocommit($koneksi, false);
$query_success = true;

$query = mysqli_query($koneksi, "INSERT INTO tb_pesanan(id_pesanan,nama_pesanan,alamat_pesanan,no_hp_pesanan,email_pesanan,total_harga_pesanan,status_pesanan,tanggal_pesanan,jenis_pembayaran) values('$id_pesanan','$nama_pesanan','$alamat_pesanan','$no_hp_pesanan','$email_pesanan','$total_harga_pesanan','Menunggu Pembayaran','$tanggal_pesanan','$jenis_pembayaran')");
//Untuk Menambahkan Pesanan Baru ke tb_pesanan dengan kolom diatas

if (!$query) {
	$query_success = false;
}

$keys       = implode(', ', array_keys($cart));
$query_cart = mysqli_query($koneksi, "SELECT * FROM tb_barang WHERE id_barang IN ($keys)");
//Untuk mengambil data barang dari database

while ($keranjang = mysqli_fetch_array($query_cart)) {
	$jumlah_pesanan = $cart[$keranjang['id_barang']];
	$id_barang      = $keranjang['id_barang'];
	$subtotal_harga = $keranjang['harga_barang'] * $jumlah_pesanan;

	$update_stok      = mysqli_query($koneksi, "UPDATE tb_barang SET stok_barang = stok_barang - '$jumlah_pesanan' WHERE id_barang = '$id_barang'");
	$update_keranjang = mysqli_query($koneksi, "INSERT INTO tb_detail_pesanan(id_pesanan,id_barang,jumlah_pesanan,subtotal_harga) VALUES ('$id_pesanan', '$id_barang', '$jumlah_pesanan', '$subtotal_harga')");

	if (!$update_stok || !$update_keranjang) {
		$query_success = false;
	}
}

if ($query_success) {
	mysqli_commit($koneksi);
	mysqli_autocommit($koneksi, true);
	$_SESSION['cart'] = [];

	echo '<script>alert("Pesanan berhasil dibuat"); document.location="status.php?s=' . $id_pesanan . '";</script>';
} else {
	mysqli_rollback($koneksi);
	mysqli_autocommit($koneksi, true);
	echo '<script>alert("Kesalahan! mohon coba lagi!"); document.location="checkout.php";</script>';

}

?>