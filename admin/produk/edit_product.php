<?php
include '../includer.php';
$no   = 1;
$id   = $_POST['id'];
$data = mysqli_query($koneksi, "SELECT * FROM tb_barang  LEFT JOIN tb_kategori ON tb_kategori.id_kategori = tb_barang.id_kategori WHERE id_barang = '$id'");
$row  = mysqli_fetch_array($data);
?>
<form role="form" id="form-edit" method="post" action="aksi_query.php">

     <input type="hidden" name="id_product" value="<?php echo $row['id_barang']; ?>">

     <input type="hidden" name="aksi" value="update">

     <div class="form-group">
          <label>Nama produk</label>
          <input class="form-control" id="product" name="nama" required="required"
               value="<?php echo $row['nama_barang']; ?>">
     </div>
     <div class="form-group">
          <label>Harga</label>
          <input class="form-control" id="product" name="harga" required="required"
               value="<?php echo $row['harga_barang']; ?>">
     </div>
     <div class="form-group">
          <label>Deskripsi</label>
          <textarea class="form-control" id="nama" name="desc" required="required"
               placeholder="Deskripsi Product"><?php echo $row['deskripsi_barang']; ?></textarea>
     </div>
     <div class="form-group">
          <label>Stok</label>
          <input class="form-control" id="product" name="stok" required="required"
               value="<?php echo $row['stok_barang']; ?>">
     </div>

     <div class="form-group">
          <label>Kategori</label>
          <select class="form-control" id="kategori" name="kategori" required="required">
               <option value="<?php echo $row['id_kategori']; ?>"><?php echo $row['nama_kategori']; ?></option>
               <?php
               $q_kategori = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
               while ($data_kat = mysqli_fetch_array($q_kategori)) {

                    if ($row['id_kategori'] == $data_kat['id_kategori']) {
                         continue;
                    }
                    ?>
                    <option value="<?php echo $data_kat['id_kategori']; ?>"><?php echo $data_kat['nama_kategori']; ?>
                    </option>
               <?php } ?>
          </select>
     </div>
     <div class="form-group">
          <label>Gambar</label>
          <input type="hidden" name="gambar1" value="<?php echo $row['foto_barang']; ?>">
          <input type="file" class="form-control" id="product" name="gambar2">
          <?php echo $row['foto_barang']; ?>
     </div>

</form>