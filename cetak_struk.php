<?php
include 'function.php';
include 'koneksi.php';
$menu = 'status';
?>
<!DOCTYPE html>
<html lang="id">

<?php include 'head.php'; ?>

<body>
    <br><br><br><br>

    <div class="container">

        <h1 class="display-5">Detail Pesanan</h1>
        <hr>

        <p>Berikut adalah detail pesanan Anda.</p>

        <?php
        $id_pesanan = strtoupper($_GET['id']);
        $query      = mysqli_query($koneksi, "SELECT *  FROM tb_pesanan WHERE id_pesanan = '$id_pesanan'");
        $data       = mysqli_fetch_array($query);
        ?>
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
            <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Total Harga</b></label>
            <div class="col-sm-10">
                <?php
                $total_belanja = mysqli_query($koneksi, "SELECT SUM(subtotal_harga) AS total from tb_detail_pesanan where id_pesanan = '$id_pesanan' ");
                //Untuk menghitung total belanja dari tb_detail_pesanan
                $total_harga   = mysqli_fetch_array($total_belanja);
                ?>
                Rp.
                <?php echo number_format($total_harga['total']); ?>
            </div>
        </div>
        <hr>

        <hr>
        <div class="form-group">
            <label for="exampleInputEmail1"><b>Informasi Pembayaran</b></label>

            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Total Harga</label>
                <div class="col-sm-10">
                    Rp.
                    <?php echo number_format($total_harga['total']); ?>
                </div>
            </div>
        </div>
        <hr>
        <br><br>

        <div class="form-group">
            <label for="exampleInputEmail1"><b>Pembayaran</b></label>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label"><b>Status Pembayaran</b></label>
                <div class="col-sm-10">
                    <?php
                    $query_bukti = mysqli_query($koneksi, "SELECT * FROM tb_bukti WHERE id_pesanan = '$id_pesanan' ");
                    //Untuk mengambil data bukti pembayaran
                    $bukti       = mysqli_fetch_array($query_bukti);
                    if ($data['jenis_pembayaran'] == 'COD') {
                        echo "COD";
                    } else if ($bukti == null) {
                        echo "Belum Dibayar";
                    } else if ($data['status_pesanan'] == 'Menunggu Pembayaran' && $bukti != null) {
                        echo "Sudah Dibayar (menunggu konfirmasi)";
                    } else if ($bukti != null) {
                        echo "Sudah Dibayar (terkonfirmasi)";
                    } else {
                        echo "-";
                    } ?>
                </div>
            </div>
        </div>

        <br><br>
        <p>@ AMOUR HIJAB </p>
        <br><br>


    </div>

</body>

</html>

<script>
    window.print();
</script>