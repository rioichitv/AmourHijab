<?php
include 'function.php';
include 'koneksi.php';
$menu = 'keranjang';

session_start();
?>

<!DOCTYPE html>
<html lang="id">
<?php include 'head.php';

if (isset($_POST['addcart'])) {
    $_SESSION['cart'][$_POST['id_barang']] = $_POST['jumlah_pesan'];
}
if (isset($_POST['deletecart'])) {
    unset($_SESSION['cart'][$_POST['id_barang']]);
}
?>

<body>
    <?php include 'navbar.php'; ?>
        <br><br><br><br>
        <br><br><br>
		<br><br><br><br>
		
		
    <div class="container-fluid">

        <?php
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

        if (count($cart) == 0) {
            ?>

            <center>
                <img src="assets/img/empty-cart-vector.png" width="250px" height="200px">
                <br>
                <h3>Keranjang Belanja Anda Kosong</h3><br>
                <a href="index.php" class="btn btn-dark">Belanja Sekarang</a>
            </center>


        <?php } else {
            $keys  = implode(', ', array_keys($cart));
            $query = mysqli_query($koneksi, "SELECT * FROM tb_barang WHERE id_barang IN ($keys)");
            //Untuk mengambil data barang dari database
            ?>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="garis"></div>
                </div>
                <div class="col-12 col-md-4">
                    <h1 class="display-5 text-center">Keranjang</h1>
                </div>
                <div class="col-12 col-md-4">
                    <div class="garis"></div>
                </div>
            </div>
            <br><br>
            <div id="data-keranjang" class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">

                        </th>
<th class="text-center">
    Produk
</th>
<th class="text-center">
    Harga
</th>
<th class="text-center">
    Jumlah Pesan
</th>
                        <th class="text-center">
                            Subtotal
                        </th>
                        <th class="text-center">
                            Opsi
                        </th>
                    </tr>
                    <?php
                    $total = 0;
                    while ($data = mysqli_fetch_array($query)) {

                        $jumlah_pesan = $cart[$data['id_barang']];
                        $subtotal     = $jumlah_pesan * $data['harga_barang'];
                        ?>
                        <tr>
                            <td class="text-center">
                                <img src="assets/produk/<?php echo $data['foto_barang']; ?>" width="100px" height="100px">
                            </td>
<td class="text-center" style="color: black;">
    <?php echo $data['nama_barang']; ?>
</td>
<td class="text-center" style="color: black;">
    Rp.
    <?php echo number_format($data['harga_barang']); ?>
</td>
<td class="text-center" style="color: black;">
    <?php echo $jumlah_pesan; ?>
</td>
                            <td class="text-center">
                                Rp.
                                <?php echo number_format($subtotal); ?>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-primary" id="edit" data-harga="<?php echo $data['harga_barang']; ?>"
                                    data-nama="<?php echo $data['nama_barang']; ?>"
                                    data-id="<?php echo $data['id_barang']; ?>"><span class="fa fa-edit fa-fw"></span></a> |
                                <button type="button" id="confirm_delete" class="btn btn-danger"
                                    data-id="<?php echo $data['id_barang']; ?>"><span class="fa fa-close fa-fw"></span></button>
                            </td>
                        </tr>
                        <?php $total += $subtotal;
                    } ?>
                    <tr>
                        <td colspan="4" class="text-right">Total Belanja</td>
                        <td colspan="2">
                            <?php $_SESSION['cart_total'] = $total; ?>
                            Rp.
                            <?php echo number_format($total); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <a href="index.php" class="btn btn-primary" style="background-color: #D68282; border-color: #D68282;">Lanjutkan Belanja</a>
            <a href="checkout.php" class="btn btn-success" style="background-color: #D68282; border-color: #D68282;">Checkout</a>

        </div>
    <?php } ?>
    </div>

    <br><br><br><br><br>

    <?php include 'foot.php' ?>
</body>

</html>

<div id="modal-edit" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" id="form-edit" method="post">
                <div class="modal-header">
<h4 class="modal-title" style="color: black;">Edit keranjang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="data-edit">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" name="addcart" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="modal-hapus" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus keranjang</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="delete-keranjang"></div>
                </div>
        </form>
    </div>
</div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#edit', function (e) {
            e.preventDefault();
            $("#modal-edit").modal('show');
            $.post('cart_edit.php',
                {
                    id: $(this).attr('data-id'),
                    nama: $(this).attr('data-nama'),
                    harga: $(this).attr('data-harga')
                },
                function (html) {
                    $("#data-edit").html(html);
                }
            );
        });

        $(document).on('click', '#confirm_delete', function (e) {
            e.preventDefault();
            $("#modal-hapus").modal('show');
            $.post('cart_delete_confirm.php',
                { id: $(this).attr('data-id') },
                function (html) {
                    $("#delete-keranjang").html(html);
                }
            );
        });


    });
</script>