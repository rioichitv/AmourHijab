<?php
include '../includer.php';
$no   = 1;
$id   = $_POST['id'];
//Untuk Mengambil Data Kategori dan diupdate dari data kategori yang sudah ada dan diupdate dengan data baru
$data = mysqli_query($koneksi, "SELECT * FROM tb_kategori WHERE id_kategori = '$id'");
$row  = mysqli_fetch_array($data);
?>
<form role="form" id="form-edit" method="post" action="aksi_query.php">

    <input type="hidden" name="id_kategori" value="<?= $row['id_kategori']; ?>">

    <input type="hidden" name="aksi" value="update">

    <div class="form-group">
        <label>Kategori</label>
        <input class="form-control" id="kategori" name="kategori" required="required"
            value="<?= $row['nama_kategori']; ?> ">
    </div>

</form>