<?php

include 'includer.php';

$menu             = 'dashboard';
$page_title       = 'Dasboard';
$page_description = 'Beranda';
//untuk menghitung jumlah data
$kategori         = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_kategori"));
$barang           = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_barang"));
$pesanan          = mysqli_fetch_array(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_pesanan"));

?>

<!DOCTYPE html>
<html lang="id">

<?php include 'header.php'; ?>

<body class="app sidebar-mini rtl">
  <?php include 'navbar.php'; ?>
  <?php include 'sidebar.php'; ?>

  <main class="app-content">
    <?php include 'title.php'; ?>

    <div class="row">
      <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-list-alt fa-3x"></i>
          <div class="info">
            <h4>Kategori</h4>
            <p><b>
                <?= $kategori['total']; ?>
              </b></p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-desktop fa-3x"></i>
          <div class="info">
            <h4>Produk</h4>
            <p><b>
                <?= $barang['total']; ?>
              </b></p>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-money fa-3x"></i>
          <div class="info">
            <h4>Pesanan</h4>
            <p><b>
                <?= $pesanan['total']; ?>
              </b></p>
          </div>
        </div>
      </div>
    </div>
    <div class="carousel-inner">
    
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include 'footer.php'; ?>
</body>

</html>