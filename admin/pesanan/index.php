<?php
include '../includer.php';
$menu             = 'pesanan';
$page_title       = 'Pesanan';
$page_description = 'Data pemesanan produk/barang';
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


            <table class="table table-bordered" id="table">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Tanggal</th>
                  <th>Nama pemesan</th>
                  <th>Total harga</th>
                  <th>Status</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no   = 1;
                $data = mysqli_query($koneksi, "SELECT *  FROM tb_pesanan ORDER BY tanggal_pesanan DESC");
                //untuk mengambil semua data pesanan dan diurutkan berdasarkan tanggal pesanan
                while ($row = mysqli_fetch_array($data)) {
                  ?>
                  <tr>
                    <td>
                      <?php echo $row['id_pesanan']; ?>
                    </td>
                    <td>
                      <?php echo $row['tanggal_pesanan']; ?>
                    </td>
                    <td>
                      <?php echo $row['nama_pesanan']; ?>
                    </td>
                    <td>Rp.
                      <?php echo number_format($row['total_harga_pesanan']); ?>
                    </td>
                    <td>
                      <?php echo $row['status_pesanan']; ?>
                    </td>
                    <td><a href="detail_transaksi.php?id_pesanan=<?php echo $row['id_pesanan']; ?>"
                        class="btn btn-primary">Detail pesanan</a></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include '../footer.php'; ?>
</body>

</html>


<script src="../docs/js/plugins/jquery.dataTables.min.js"></script>
<script src="../docs/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">$('#table').DataTable();</script>