<?php

include 'koneksi.php';

error_reporting(0);
$id_customer = $_SESSION['id_customer'];

$id_product   = $_POST['id_product'];
$nama_product = $_POST['nama_product'];
$harga        = $_POST['harga'];
$qty          = $_POST['qty'];
$subtotal     = $qty * $harga;
$cek          = mysqli_query($koneksi, "SELECT*FROM product where id_product = '$id_product'");
//untuk mengecek apakah barang tersebut ada di database
$product      = mysqli_fetch_array($cek);



$cek_keranjang    = mysqli_query($koneksi, "SELECT*FROM keranjang where id_transaksi = 'Belum Ada Transaksi' AND id_customer = '$id_customer' AND id_product = '$id_product'");
//Untuk Mengecek apakah barang tersebut sudah ada di keranjang atau belum
$jumlah_keranjang = mysqli_num_rows($cek_keranjang);
$keranjang        = mysqli_fetch_array($cek_keranjang);
if ($jumlah_keranjang == 1) {
	$qty_baru      = $keranjang['qty'] + $qty;
	$subtotal_baru = $qty_baru * $harga;
	if ($product['stok'] < $qty_baru) {

		echo '<script>alert("Stok Product Tidak Cukup!"); document.location="detail_product.php?id_product=' . $id_product . '";</script>';
	} else {

		$update_keranjang = mysqli_query($koneksi, "UPDATE keranjang SET qty = '$qty_baru',subtotal = '$subtotal_baru' where id_transaksi = 'Belum Ada Transaksi' AND id_customer = '$id_customer' AND id_product = '$id_product'");

		echo '<script>alert("Barang Dimasukan Kedalam Keranjang!"); document.location="customer/keranjang.php";</script>';
	}
} else {
	$sql     = "SELECT id_keranjang as maxid FROM keranjang order by id_keranjang desc";
	//Untuk Mendapatkan ID Terbesar dari Keranjang 
	$hasil   = mysqli_query($koneksi, $sql);
	$data    = mysqli_fetch_array($hasil);
	$id_user = $data['maxid'];
	$noUrut  = (int) substr($id_user, 10);
	$noUrut++;

	$char  = "Keranjang_";
	$newID = $char . $noUrut;


	$query = mysqli_query($koneksi, "INSERT INTO keranjang values('$newID','Belum Ada Transaksi','$id_customer','$id_product','$nama_product','$qty','$harga','$subtotal')");
	//Untuk Menambahkan Barang ke Keranjang
	if ($query) {

		echo '<script>alert("Barang Dimasukan Kedalam Keranjang!"); document.location="customer/keranjang.php";</script>';

	} else {

		echo '<script>alert("Error Mohon Coba Lagi!"); document.location="customer/keranjang.php";</script>';

	}
}








?>