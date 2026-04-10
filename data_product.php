<?php
include 'koneksi.php';

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'show-all';
$page = isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

// Count total products for pagination
if ($action == "show-all") {
    $count_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_barang");
    //untuk menghitung jumlah data
} else {
    $count_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM tb_barang WHERE id_kategori = '$action'");
    //untuk menghitung jumlah data dari kategori yang dipilih
}
$count_result = mysqli_fetch_assoc($count_query);
$total_products = $count_result['total'];
$total_pages = ceil($total_products / $limit);

// Fetch products with limit and offset
if ($action == "show-all") {
    $query = mysqli_query($koneksi, "SELECT * FROM tb_barang ORDER BY id_barang DESC LIMIT $limit OFFSET $offset");
    //untuk menampilkan semua data dari tb_barang diurutkan berdasarkan id_barang dengan limit dan offset
} else {
    $query = mysqli_query($koneksi, "SELECT * FROM tb_barang WHERE id_kategori = '$action' ORDER BY id_barang DESC LIMIT $limit OFFSET $offset");
    //untuk menampilkan semua data dari tb_barang diurutkan berdasarkan id_barang yang dipilih dari kategori dan diurutkan dengan limit dan offset
}
?>

<div class="row about-us">
<?php
while ($data = mysqli_fetch_array($query)) {
    ?>
    <div class="col-md-3">
      <br>
      <div class="">
        <a href="detail_product.php?id_product=<?php echo $data['id_barang']; ?>"
          title="<?php echo $data['nama_barang']; ?>">
          <img src="assets/produk/<?php echo $data['foto_barang']; ?>" class="card-img-top"
            alt="<?php echo $data['nama_barang']; ?>" height="300px">
          <div class="card-body">
            <h5 class="card-title text-center">
              <?php echo $data['nama_barang']; ?>
            </h5>
        </a>
        <a href="detail_product.php?id_product=<?php echo $data['id_barang']; ?>" class="btn btn-view-product btn-block">
          View Product</a>
      </div>
    </div>
  </div>
<?php } ?>
</div>
<br><br><br>
<nav aria-label="Page navigation example" style="margin-bottom: 40px;">
  <ul class="pagination justify-content-center">
    <?php if ($page > 1): ?>
      <li class="page-item"><a class="page-link" href="#" data-page="<?php echo $page - 1; ?>">&laquo;</a></li>
    <?php endif; ?>

    <?php
    for ($i = 1; $i <= $total_pages; $i++) {
        $active = ($i == $page) ? 'active' : '';
        echo "<li class='page-item $active'><a class='page-link' href='#' data-page='$i'>$i</a></li>";
    }
    ?>

    <?php if ($page < $total_pages): ?>
      <li class="page-item"><a class="page-link" href="#" data-page="<?php echo $page + 1; ?>">&raquo;</a></li>
    <?php endif; ?>
  </ul>
</nav>
