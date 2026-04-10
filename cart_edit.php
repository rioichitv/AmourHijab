<?php
session_start();
$id_barang    = $_POST['id'];
$harga_barang = $_POST['harga'];
$nama_barang  = $_POST['nama'];

$jumlah_pesan = $_SESSION['cart'] ? $_SESSION['cart'][$id_barang] : 0;
?>

<input type="hidden" name="id_barang" value="<?= $id_barang; ?>">
<input type="hidden" name="aksi" value="update">
<div class="form-group">
     <label style="color: black;">Nama Produk</label>
     <input class="form-control" id="keranjang" name="nama_barang" required value="<?= $nama_barang ?>" disabled>
</div>
<div class="form-group">
     <label style="color: black;">Harga</label>
     <input type="number" class="form-control" id="keranjang" name="harga_barang" required value="<?= $harga_barang ?>"
          disabled>
</div>
<div class="form-group">
     <label style="color: black;">Qty</label>
     <input type="number" class="form-control" id="keranjang" name="jumlah_pesan" required value="<?= $jumlah_pesan ?>"
          min="0" max="<?= $product['stok']; ?>">
</div>
