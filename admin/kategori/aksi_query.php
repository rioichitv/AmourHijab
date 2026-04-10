<?php
//Kegunaan Dari aksi_query untuk menyimpan data dan update data kategori
include '../includer.php';

$aksi = $_POST['aksi'];
if ($aksi == 'insert') {
//Untuk Menambahkan Kategori
	$kategori = $_POST['kategori'];
	$query    = "INSERT INTO tb_kategori (nama_kategori) VALUES('$kategori')";

	mysqli_query($koneksi, $query) or die("Gagal Perintah SQL" . mysqli_error($koneksi));

} else if ($aksi == 'update') {
	$id_kategori = $_POST['id_kategori'];
	$kategori    = $_POST['kategori'];

	$query = "UPDATE tb_kategori SET nama_kategori = '$kategori' WHERE id_kategori = '$id_kategori'";

	mysqli_query($koneksi, $query)
		or die("Gagal Perintah SQL" . mysqli_error($koneksi));
//Untuk Update Kategori dari data kategori yang sudah ada dan diupdate dengan data baru

} else {
//Untuk Menghapus Kategori
	$id    = $_POST['id'];
	$query = "DELETE FROM tb_kategori WHERE id_kategori ='$id'";
	mysqli_query($koneksi, $query) or die("Gagal Perintah SQL" . mysqli_error($koneksi));
}



?>