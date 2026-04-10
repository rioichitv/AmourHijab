<?php
include '../includer.php';

$aksi = $_POST['aksi'];
if ($aksi == 'insert') {
	$nama_barang      = $_POST['nama'];
	$harga_barang     = $_POST['harga'];
	$deskripsi_barang = $_POST['desc'];
	$stok_barang      = $_POST['stok'];
	$id_kategori      = $_POST['kategori'];


	// ambil data file
	$namaFile      = $_FILES['gambar']['name'];
	$namaSementara = $_FILES['gambar']['tmp_name'];

	// tentukan lokasi file akan dipindahkan
	$dirUpload = "../../assets/produk/";

	// pindahkan file
	$uniqueName    = generateUniqueCode();
	$new_file_name = $uniqueName . $namaFile;
	$terupload     = move_uploaded_file($namaSementara, $dirUpload . $new_file_name);

	if ($terupload) {
		$query = "INSERT INTO tb_barang(id_kategori, nama_barang, deskripsi_barang, harga_barang, stok_barang, foto_barang) VALUES('$id_kategori','$nama_barang','$deskripsi_barang','$harga_barang','$stok_barang','$new_file_name')";

		mysqli_query($koneksi, $query) or die("Gagal Perintah SQL" . mysqli_error($koneksi));
	} else {
		echo '<script>alert("Gagal Upload File!"); document.location="index.php";</script>';
	}

} else if ($aksi == 'update') {

	$id_barang        = $_POST['id_product'];
	$nama_barang      = $_POST['nama'];
	$harga_barang     = $_POST['harga'];
	$deskripsi_barang = $_POST['desc'];
	$stok_barang      = $_POST['stok'];
	$id_kategori      = $_POST['kategori'];

	$gambar1 = $_POST['gambar1'];
	$gambar  = '';

	// ambil data file
	$namaFile      = $_FILES['gambar2']['name'];
	$namaSementara = $_FILES['gambar2']['tmp_name'];

	// tentukan lokasi file akan dipindahkan
	$dirUpload = "../../assets/produk/";

	$uniqueName    = generateUniqueCode();
	$new_file_name = $uniqueName . $namaFile;
	$terupload     = move_uploaded_file($namaSementara, $dirUpload . $new_file_name);

	if ($terupload) {
		$gambar = $new_file_name;
	} else {
		$gambar = $gambar1;
	}

	$query = "UPDATE tb_barang SET nama_barang = '$nama_barang', harga_barang = '$harga_barang', deskripsi_barang = '$deskripsi_barang',  stok_barang = '$stok_barang', id_kategori = '$id_kategori', foto_barang ='$gambar' where id_barang = '$id_barang'";

	mysqli_query($koneksi, $query)
		or die("Gagal Perintah SQL" . mysqli_error($koneksi));


} else {

	$id    = $_POST['id'];
	$query = "DELETE FROM tb_barang WHERE id_barang ='$id'";
	mysqli_query($koneksi, $query) or die("Gagal Perintah SQL" . mysqli_error($koneksi));
}



?>