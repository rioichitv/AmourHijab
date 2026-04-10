<?php
include '../includer.php';

$menu             = 'produk';
$page_title       = 'Produk';
$page_description = 'Data produk/barang yang dijual';
?>
<!DOCTYPE html>
<html lang="en">

<?php include '../header.php'; ?>

<body class="app sidebar-mini rtl">
  <?php include '../navbar.php'; ?>
  <?php include '../sidebar.php'; ?>
  <main class="app-content">
    <?php include '../title.php'; ?>
    <div class="row">
      <div class="col-md-12">
        <div class="tile">
          <div class="tile-body">

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-tambah">Tambah
              Produk</button><br> <br>

            <div style="overflow-x: auto;">
              <div id="data-product"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include '../footer.php'; ?>
  <script src="ajax_product.js"></script>
</body>

</html>

<div id="modal-tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" id="form-tambah" enctype="multipart/form-data" method="post" action="aksi_query.php">
        <div class="modal-header">
          <h4 class="modal-title">Menambahkan produk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">

          <div class="form-group">
            <label>Nama produk</label>
            <input class="form-control" id="nama" name="nama" required="required" placeholder="Nama produk">
          </div>
          <div class="form-group">
            <label>Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" required="required" placeholder="Harga">
          </div>
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea class="form-control" id="nama" name="desc" required="required"
              placeholder="Deskripsi produk"></textarea>
          </div>
          <div class="form-group">
            <label>Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required="required" placeholder="Stok">
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select class="form-control" id="kategori" name="kategori" required="required">
              <option selected disabled="true">--Pilih kategori produk--</option>
              <?php
              $q_kategori = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
              while ($data_kat = mysqli_fetch_array($q_kategori)) {
                ?>
                <option value="<?php echo $data_kat['id_kategori']; ?>"><?php echo $data_kat['nama_kategori']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar" required="required">
          </div>

        </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        <input type="hidden" name="aksi" value="insert">
      </form>
    </div>
  </div>
</div>


<div id="modal-edit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" id="form-edit" method="post" action="aksi_query.php">
        <div class="modal-header">
          <h4 class="modal-title">Ubah produk</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div id="data-edit">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        <input type="hidden" name="aksi" value="update">
      </form>
    </div>
  </div>
</div>

<div id="modal-hapus" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Hapus produk</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="delete-product"></div>
      </div>
      </form>
    </div>
  </div>
</div>