<?php
include '../includer.php';

$menu             = 'kategori';
$page_title       = 'Kategori';
$page_description = 'Data kategori produk/barang';
?>
<!DOCTYPE html>
<html lang="id">

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
              Kategori
            </button><br> <br>

            <div id="data-kategori"></div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include '../footer.php'; ?>
  <script src="ajax_kategori.js"></script>
</body>

</html>

<div id="modal-tambah" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form role="form" id="form-tambah" method="post" action="aksi_query.php">
        <div class="modal-header">
          <h4 class="modal-title">Menambahkan kategori</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Kategori</label>
            <input class="form-control" id="kategori" name="kategori" required="required" placeholder="Kategori">
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
      <form role="form" id="form-edit" method="post" action="update_kategori.php">
        <div class="modal-header">
          <h4 class="modal-title">Edit kategori</h4>
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
      </form>
    </div>
  </div>
</div>

<div id="modal-hapus" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Hapus kategori</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div id="delete-kategori"></div>
      </div>
      </form>
    </div>
  </div>
</div>