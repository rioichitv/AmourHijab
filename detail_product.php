<?php
include 'koneksi.php';
include 'function.php';
$menu = 'beranda';
?>

<!DOCTYPE html>
<html lang="id">

<?php include 'head.php' ?>

<body>

  <?php include 'navbar.php' ?>
  <div class="jumbotron" style="margin: 0;">
    <div class="jumbotron jumbotron-fluid" style="margin: 0;">
      <div class="container">
        <?php

        $id    = $_GET['id_product'];
        $query = mysqli_query($koneksi, "SELECT * FROM tb_barang where id_barang = '$id'");
        //untuk menampilkan semua data dari tb_barang
        $data  = mysqli_fetch_array($query)
          ?>

        <div class="row">
          <div class="col-md-6">
            <img src="assets/produk/<?php echo $data['foto_barang']; ?>" height="500px" width="100%">
          </div>
          <div class="col-md-6">
            <h3 class="font-weight-bold">
              <?php echo $data['nama_barang']; ?>
            </h3>
            <p class="text-justify display-5">
              <?php echo $data['deskripsi_barang']; ?>
            </p>
            <br>
            <h5>Rp.
              <?php echo number_format($data['harga_barang']); ?>
            </h5><br>
            <?php if ($data['stok_barang'] > 1) { ?>
            <h4 style="color: black;">Stok Tersedia: <?php echo $data['stok_barang']; ?> barang</h4>
            <br>
             <?php } ?>
            <form role="form" id="form-tambah" action="cart.php" method="post">
              <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">
              <div class="form-group">
                <label>Jumlah pesan</label>
                <input type="number" class="form-control" id="qty" name="jumlah_pesan" required value="1" min="1"
                  max="<?php echo $data['stok_barang']; ?>">
              </div>
              <?php if ($data['stok_barang'] < 1) { ?>
                <h4 class="text-danger">Stok Habis</h4>
              <?php } else { ?>
                <button type="submit" name="addcart" class="btn" style="background-color: #D68282; color: black; border: none;">Tambah ke keranjang</button>
              <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php include 'foot.php' ?>
</body>

</html>
