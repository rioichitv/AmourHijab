<?php
include '../includer.php';

$menu             = 'pesanan';
$page_title       = 'Detail Pesanan';
$page_description = 'Data informasi pemesanan produk/barang';

$status_option = ['Menunggu Pembayaran', 'Diproses', 'Dikirim', 'Selesai'];
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
            $id_pesanan = $_GET['id_pesanan'];
            $query      = mysqli_query($koneksi, "SELECT *  FROM tb_pesanan WHERE id_pesanan = '$id_pesanan'");
            $data       = mysqli_fetch_array($query);
            ?>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Status</b></label>
              <div class="col-sm-10">
                Saat Ini : <b>
                  <?php echo $data['status_pesanan']; ?>
                </b><br><br>

                <form method="POST" action="aksi_detail.php">
                  <input type="hidden" name="id_pesanan" value="<?php echo $data['id_pesanan'] ?>">
                  <select class="form-control" id="status" name="status" required>

                    <?php
                    foreach ($status_option as $option) {
                      ?>
                      <option value="<?= $option ?>" <?= $data['status_pesanan'] == $option ? 'selected' : ''; ?>><?= $option; ?></option>
                      <?php
                    }
                    ?>
                  </select>
                  <br>
                  <input type="hidden" name="aksi" value="ubah_status">
                  <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                </form>

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

            <div class="form-group">
              <label for="exampleInputEmail1"><b>Informasi Pemesan</b></label>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                  <?php echo $data['nama_pesanan']; ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <?php echo $data['alamat_pesanan']; ?>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nomor Handphone</label>
                <div class="col-sm-10">
                  <?php echo $data['no_hp_pesanan']; ?>
                </div>
              </div>
            </div>
            <hr>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Daftar Produk Pesanan</b></label>
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
                      Jumlah Pesanan
                    </th>
                    <th class="text-center">
                      Subtotal
                    </th>
                  </tr>
                  <?php
                  //ambil semua data dari tb_detail_pesanan, dan jika ada kecocokan di tb_barang, 
                  //ambil data dari tb_barang. Jika tidak ada kecocokan di tb_barang, data dari tb_barang akan bernilai NULL / 0
                  $query_keranjang = mysqli_query($koneksi, query: "SELECT * FROM tb_detail_pesanan LEFT JOIN tb_barang ON tb_barang.id_barang = tb_detail_pesanan.id_barang WHERE id_pesanan = '$id_pesanan' ORDER BY id_detail DESC");
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
                //total harga belanja diambil dari tb_detail_pesanan dan dijumlahkan dan disimpan di variabel $total_harga
                $total_harga   = mysqli_fetch_array($total_belanja);
                ?>
                Rp.
                <?php echo number_format($total_harga['total']); ?>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Ongkos Kirim</b></label>
              <div class="col-sm-10">
                Rp.
                <?php echo number_format($data['ongkos_kirim']); ?>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Total Keseluruhan</b></label>
              <div class="col-sm-10">
                Rp.
                <?php echo number_format($total_harga['total'] + $data['ongkos_kirim']); ?>
              </div>
            </div>
            <hr>

            <?php
            $query_bukti = mysqli_query($koneksi, "SELECT * FROM tb_bukti WHERE id_pesanan = '$id_pesanan' ");
            $bukti       = mysqli_fetch_array($query_bukti);

            if ($data['jenis_pembayaran'] == 'COD') {
              ?>
              <div class="form-group">
                <label for="exampleInputEmail1"><b>Pembayaran</b></label>
                <h5>Transaksi COD (Cash On Delivery)</h5>
              </div>
            <?php } else { ?>
              <div class="form-group">
                <label for="exampleInputEmail1"><b>Bukti Pembayaran</b></label>

                <?php if ($bukti == null) {
                  ?>
                  <h5>Belum Mengirim Bukti Pembayaran</h5>
                <?php } else { ?>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Bukti Pembayaran</label>
                    <div class="col-sm-10">
                      <a href="#" data-toggle="modal" data-target="#detail-transaksi">
                        <img src="../../assets/bukti_transaksi/<?php echo $bukti['foto_bukti']; ?>" width="100px"
                          height="100px">
                      </a>
                    </div>
                  </div>
                <?php } ?>

              </div>

            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include '../footer.php'; ?>
  <script src="ajax_transaksi.js"></script>
  <!-- Page specific javascripts-->
  <!-- Google analytics script-->
</body>

</html>

<div id="detail-transaksi" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Bukti Pembayaran</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <img src="../../assets/bukti_transaksi/<?php echo $bukti['foto_bukti']; ?>" width="100%" height="100%">
      </div>
      </form>
    </div>
  </div>
</div>