<?php
include '../includer.php';

$menu             = 'laporan';
$page_title       = 'Laporan Pesanan';
$page_description = 'Cetak laporan data pemesanan';
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

            <?php

            $semuadata = array();
            $mulai     = "-";
            $selesai   = "-";
            if (isset($_POST['lihat'])) {
              $mulai    = $_POST['tglm'];
              $selesai  = $_POST['tgls'];
              $mulai1   = date("d-M-Y", strtotime($mulai));
              $selesai1 = date("d-M-Y", strtotime($selesai));
              // Select data
              $ambil    = $koneksi->query("SELECT * FROM tb_pesanan WHERE tanggal_pesanan BETWEEN '$mulai' AND '$selesai'");
              while ($pecah = $ambil->fetch_assoc()) {
                $semuadata[] = $pecah;
              }
            }

            ?>

            <form method="post">
              <div class="row">
                <div class="col-md-5">
                  <div class="form-group">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tglm" class="form-control" value="<?php echo $mulai ?>">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tgls" class="form-control" value="<?php echo $selesai ?>">
                  </div>
                </div>
                <div class="col-md-2">
                  <label>&nbsp;</label><br>
                  <button class="btn btn-primary" name="lihat">Lihat</button>
                  <?php if ($semuadata != null) { ?>
                    <a class="btn btn-primary text-white" onclick="window.open('cetak_laporan.php?mulai=<?php echo $mulai; ?>&selesai=<?php echo $selesai; ?> ', 'newwindow','width=800,height=500'); 
                     return false;">Print</a>
                  <?php } ?>
                </div>
              </div>
            </form>
            <div id="laporan_transaksi">
              <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Pemesan</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <?php $total = 0; ?>
                <?php foreach ($semuadata as $key => $value): ?>
                  <?php $total += $value['total_harga_pesanan']; ?>

                  <tbody>
                    <tr>
                      <td>
                        <?php echo $key + 1; ?>
                      </td>
                      <td>
                        <?php echo $value['nama_pesanan']; ?>
                      </td>
                      <td>
                        <?php echo $value['tanggal_pesanan']; ?>
                      </td>
                      <td>Rp.
                        <?php echo number_format($value['total_harga_pesanan']); ?>
                      </td>
                      <td>
                        <?php echo $value['status_pesanan']; ?>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>

                <tfoot>
                  <tr>
                    <?php if ($semuadata == null) { ?>

                      <th colspan="2"></th>
                      <th>Tidak Ada Data</th>
                      <th colspan="2"></th>
                    <?php } else { ?>
                      <th colspan="3">Total</th>
                      <th>Rp.
                        <?php echo number_format($total); ?>
                      </th>
                      <th></th>
                    <?php } ?>
                  </tr>
                  <tr>
                  </tr>
                </tfoot>
              </table>
            </div>


          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include '../footer.php'; ?>
</body>

</html>