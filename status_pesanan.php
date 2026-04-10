<?php
include 'function.php';
include 'koneksi.php';
$menu = 'status';

if (!isset($_POST['kode_pesanan'])) {
	header('location: status.php');
}
$id_pesanan = strtoupper($_POST['kode_pesanan']);


if (isset($_POST['upload_bukti'])) {
	$namaFile      = $_FILES['foto_bukti']['name'];
	$namaSementara = $_FILES['foto_bukti']['tmp_name'];

	// tentukan lokasi file akan dipindahkan
	$dirUpload = "assets/bukti_transaksi/";

	$query_check = mysqli_query($koneksi, "SELECT *  FROM tb_bukti WHERE id_pesanan = '$id_pesanan'");
	//untuk mengecek apakah bukti pembayaran sudah ada
	$data_check  = mysqli_fetch_array($query_check);

	if ($data_check != null) {
		echo '<script>alert("Sudah terdapat bukti pembayaran!")</script>';
	} else {
		$uniqueName    = generateUniqueCode();
		$new_file_name = $uniqueName . $namaFile;
		$terupload     = move_uploaded_file($namaSementara, $dirUpload . $new_file_name);

		if ($terupload) {
			$query = "INSERT INTO tb_bukti(id_pesanan, foto_bukti) VALUES('$id_pesanan','$new_file_name')";
			mysqli_query($koneksi, $query) or die("Gagal Perintah SQL" . mysqli_error($koneksi));
			echo '<script>alert("Sukses unggah bukti pembayaran!")</script>';

		} else {
			echo '<script>alert("Gagal unggah bukti pembayaran!")</script>';
		}
	}

}
?>
<!DOCTYPE html>
<html lang="id">

<?php include 'head.php'; ?>

<body>

	<?php include 'navbar.php'; ?>

	<br><br><br><br>

	<div class="container">

		<?php
		$query = mysqli_query($koneksi, "SELECT *  FROM tb_pesanan WHERE id_pesanan = '$id_pesanan'");
		//SELECT
		$data  = mysqli_fetch_array($query);
		?>
		<a href="status.php">
			< Kembali</a>
				<h1 class="display-5">Status Pesanan</h1>
				<?php
				if ($data == null) { ?>
					<br><br>
					<label for="exampleInputEmail1"><b>Pesanan dengan kode pesanan:
							<?= $id_pesanan ?> tidak ditemukan!
						</b> <a href="status.php">Kembali</a></label>
				<?php } else {
					?>
					Silahkan cetak halaman <a href="" onclick="window.open('cetak_struk.php?id=<?php echo $id_pesanan; ?>', 'newwindow','width=800,height=500'); 
		return false;">Klik Disini</a> untuk mengingat detail pemesanan Anda.

					<hr>

					<p>Berikut adalah detail status pesanan Anda. Untuk pembatalan pesanan silakan hubungi nomor pada link
						berikut:
						<a href="https://wa.me/6281317815664">hubungi</a>
					</p>

					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-2 col-form-label"><b>Status Pesanan</b></label>
						<div class="col-sm-10">
							<b>
								<?= $data['jenis_pembayaran'] == "COD" && $data['status_pesanan'] == "Menunggu Pembayaran" ? "Menunggu Konfirmasi" : $data['status_pesanan']; ?>
							</b>
						</div>
					</div>
					<hr>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-2 col-form-label"><b>Tanggal Pemesanan</b></label>
						<div class="col-sm-10">
							<b>
								<?php echo $data['tanggal_pesanan']; ?>
							</b>
						</div>
					</div>
					<hr>

					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-2 col-form-label"><b>Kode Pesanan</b></label>
						<div class="col-sm-10">
							<b>
								<?php echo $data['id_pesanan']; ?>
							</b>
						</div>
					</div>
					<hr>

					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-2 col-form-label"><b>Daftar Produk</b></label>
						<div class="col-sm-10">
							<table class="table table-borderless">
								<tr>
									<th class="text-center">
										Produk
									</th>
									<th class="text-center">
										Harga
									</th>
									<th class="text-center">
										Jumlah pesanan
									</th>
									<th class="text-center">
										Subtotal
									</th>
								</tr>
								<?php
								$query_keranjang = mysqli_query($koneksi, "SELECT * FROM tb_detail_pesanan LEFT JOIN tb_barang ON tb_barang.id_barang = tb_detail_pesanan.id_barang WHERE id_pesanan = '$id_pesanan' ORDER BY id_detail DESC");
								// jika ada kecocokan di tb_barang, ambil data dari tb_barang dan jika tidak ada kecocokan di tb_barang, data dari tb_barang akan bernilai NULL
								while ($keranjang = mysqli_fetch_array($query_keranjang)) { ?>

									<tr>
										<td class="text-center">
											<?php echo $keranjang['nama_barang']; ?>
										</td>
										<td class="text-center">
											Rp.
											<?php echo number_format($keranjang['harga_barang']); ?>
										</td>
										<td class="text-center">
											<?php echo $keranjang['jumlah_pesanan']; ?>
										</td>
										<td class="text-center">
											Rp.
											<?php echo number_format($keranjang['subtotal_harga']); ?>
										</td>
									</tr>
								<?php } ?>
							</table>

						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-2 col-form-label"><b>Harga Barang</b></label>
						<div class="col-sm-10">
							<?php
							$total_belanja = mysqli_query($koneksi, "SELECT SUM(subtotal_harga) AS total from tb_detail_pesanan where id_pesanan = '$id_pesanan' ");
							//SELECT SUM
							$total_harga   = mysqli_fetch_array($total_belanja);
							?>
							Rp.
							<?php echo number_format($total_harga['total']); ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-2 col-form-label"><b>Harga Ongkos Kirim</b></label>
						<div class="col-sm-10">
							Rp.
							<?php echo number_format($data['ongkos_kirim']); ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="inputEmail3" class="col-sm-2 col-form-label"><b>Harga Keseluruhan</b></label>
						<div class="col-sm-10">
							Rp.
							<?php echo number_format($total_harga['total'] + $data['ongkos_kirim']); ?>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<label for="exampleInputEmail1"><b>Informasi Pembayaran</b></label>
						<div class="form-group row">
							<label for="inputEmail3" class="col-sm-2 col-form-label"><b>Total Pembayaran</b></label>
							<div class="col-sm-10">
								Rp.
								<?php echo number_format($total_harga['total'] + $data['ongkos_kirim']); ?>
							</div>
						</div>
					</div>
					<hr>
					<?php
					if ($data['jenis_pembayaran'] == 'COD') { ?>
						<h5 class="text-info">Pembayaran dilakukan secara COD (Cash On Delivery)</h5>

					<?php } else { ?>

						<div class="media border p-3">
							<img src="assets/img/logo-bri.jpg" alt="No. rek Amour Hijab" class="mr-3 mt-3 rounded-circle"
								width="150px" height="100px">
							<div class="media-body">
								<h4>BRI</h4>
								<h5>3431984413</h5>
								<h5>a.n Amour Hijab</h5>
							</div>
						</div>
						<br>
						Cantumkan Kode Pesanan : <b>
							<?php echo $data['id_pesanan']; ?>
						</b> Pada Berita Transfer/Catatan Transfer

						<hr>
						<div class="form-group">
							<label for="exampleInputEmail1"><b>Unggah Bukti Pembayaran</b></label>

							<?php
							$query_bukti = mysqli_query($koneksi, "SELECT * FROM tb_bukti WHERE id_pesanan = '$id_pesanan' ");
							// SELECT
							$bukti       = mysqli_fetch_array($query_bukti);
							?>
							<?php if ($bukti == null) {
								?>
								<form method="POST" enctype="multipart/form-data">
									<div class="form-group row">
										<label for="inputEmail3" class="col-sm-2 col-form-label">Unggah Bukti</label>
										<div class="col-sm-10">
											<input type="hidden" name="kode_pesanan" value="<?php echo $data['id_pesanan']; ?>">
											<input type="file" accept="image/png, image/jpeg, image/jpg" id="gambar"
												name="foto_bukti" required>
										</div>
									</div>
									<button type="submit" class="btn btn-primary" name="upload_bukti">Unggah</button>
								</form>
								<?php

							} else if ($data['status_pesanan'] == 'Menunggu Pembayaran' && $bukti != null) {
								?>
									<h5 class="text-warning">Bukti pembayaran menunggu verifikasi dari Admin.</h5>

							<?php } else if ($bukti != null) {
								?>
										<h5 class="text-success">Bukti pembayaran telah dikonfirmasi</h5>
							<?php } ?>
						</div>
					<?php }
				} ?>
				<br><br><br><br>

	</div>

	<?php include 'foot.php' ?>

</body>

</html>