<?php
include '../includer.php';

$aksi       = $_POST['aksi'];
$id_pesanan = $_POST['id_pesanan'];
if ($aksi == 'ubah_status') {

	$status = $_POST['status'];

	$update_transaksi = mysqli_query($koneksi, "UPDATE tb_pesanan SET status_pesanan = '$status' WHERE id_pesanan = '$id_pesanan'");
	//untuk mengupdate data dari tb_pesanan di database menjadi $status
	if ($update_transaksi) {

		echo '<script>alert("Status Sukses Diupdate!"); document.location="detail_transaksi.php?id_pesanan=' . $id_pesanan . '";</script>';

	} else {

		echo '<script>alert("Status Gagal Diupdate!"); document.location="detail_transaksi.php?id_pesanan=' . $id_pesanan . '";</script>';

	}



}
?>