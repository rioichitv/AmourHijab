<?php
include 'function.php';
include 'koneksi.php';
$menu = 'keranjang';

session_start();
?>

<!DOCTYPE html>
<html lang="id">
<?php include 'head.php';

if (!isset($_SESSION['cart_total'])) {
	header('location: cart.php');
}
?>

<body>
	<?php include 'navbar.php'; ?>
	<br><br><br><br>

	<div class="container">

		<h1 class="display-5">Checkout</h1>
		<hr>
<?php
$is_logged_in = false;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ((isset($_SESSION['id_user']) && isset($_SESSION['role']) && $_SESSION['role'] === 'member') || isset($_SESSION['id_admin'])) {
    $is_logged_in = true;
	//untuk mengecek apakah user sudah login atau belum sesuai role
}
?>

		<form method="POST" action="checkout_action.php" onsubmit="return validateForm()">

<?php if (!$is_logged_in): ?>
    <div class="alert alert-danger" role="alert">
        Silahkan Login terlebih dahulu untuk memesan!
    </div>
<?php endif; ?>

			<div class="form-group">
				<label>Nama Pemesan</label>
				<input type="text" class="form-control" name="nama_pesanan" placeholder="Misal: Amour..." required <?php if (!$is_logged_in) echo 'disabled'; ?>>
			</div>

			<div class="form-group">
				<label>Telepon/Whatsapp</label>
				<input type="number" onchange="cekOperator(this)" class="form-control" name="no_hp_pesanan" placeholder="Misal: 6283..." required <?php if (!$is_logged_in) echo 'disabled'; ?>>
				<small id="num-error" class="text-danger"></small>
				<small id="num-success" class="text-success"></small>
			</div>

			<div class="form-group">
				<label>Alamat</label>
				<input type="text" class="form-control" name="alamat_pesanan" placeholder="Misal: Jl. Veteran..."
					required <?php if (!$is_logged_in) echo 'disabled'; ?>>
			</div>

			<div class="form-group">
				<label>Email</label>
				<input type="email" class="form-control" name="email_pesanan" placeholder="Misal: Amour@gmail.com..."
					required <?php if (!$is_logged_in) echo 'disabled'; ?>>
			</div>
			<div class="row">
				<div class="col">
					<label>Total Pembelian</label>
					<br>
					<h5>Rp.
						<?= $_SESSION['cart_total']; ?>
					</h5>
				</div>
				<div class="col-md-auto">
				</div>
				<div class="col col-lg-2">
					<label>Total Ongkos Kirim</label>
					<br>
					<h5>Rp.
						<?= $_SESSION['cart_total'] > 100000 ? 0: 10000; ?>
					</h5>
					<input type="hidden" name="total" value="<?= $_SESSION['cart_total']; ?>">
				</div>
			</div>
			<br>
			<div class="form-group">
				<label class="text-danger">Gratis ongkos kirim untuk pembelian melebihi Rp 100.000</label>
			</div>

			<div class="row">
				<div class="col">
					<label>Jenis Pembayaran</label>
					<br>
						<div class="btn-group btn-group-toggle" data-toggle="buttons">
							<label class="btn btn-outline-secondary active">
								<input type="radio" name="jenis_pembayaran" value="Transfer" id="option1" autocomplete="off"
									checked>
								Transfer
							</label>
							<label class="btn btn-outline-secondary">
								<input type="radio" name="jenis_pembayaran" value="COD" id="option2" autocomplete="off"> COD
							</label>
						</div>
				</div>
				<div class="col-md-auto">
				</div>
				<div class="col col-lg-2">
					<label>Total Pembayaran</label>
					<br>
					<h5>Rp.
						<?= $_SESSION['cart_total'] > 100000 ? $_SESSION['cart_total'] : $_SESSION['cart_total'] + 10000; ?>
					</h5>
					<input type="hidden" name="total" value="<?= $_SESSION['cart_total']; ?>">

				</div>
			</div>
			<br>
			<div class="form-group">
				<div class="g-recaptcha" data-sitekey="6Le-XVwrAAAAAE7t2VEDZGZRF7NnMOJCkjwv3wrT"></div>
			</div>

			<div class="row">
				<div class="col">
					<a href="cart.php" class="btn btn-secondary">Kembali</a>
				</div>
				<div class="col-md-auto">
				</div>
				<div class="col col-lg-2">
					<button type="reset" class="btn btn-danger">Reset</button>
					<button type="submit" class="btn btn-primary" <?php if (!$is_logged_in) echo 'disabled'; ?>>Pesan</button>
				</div>
			</div>
		</form>


		<br><br><br><br>


	</div>

	<?php include 'foot.php' ?>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="noTelp.js"></script>
	<script>
	    let validNum = false;
	    function cekOperator(el){
	      const no = el.value;
	      const validate = getOperator(no,true)
	      
	      const err = document.querySelector('#num-error');
	      const succ = document.querySelector('#num-success');
	      
	      err.textContent = '';
	      succ.textContent = '';
	      
	      if(!validate.valid){
	          err.textContent = `Nomor tidak valid (${validate.message}).`
	          validNum = false;
	          return false;
	      }
	      
	      succ.textContent = `${validate.operator} (${validate.card})`
	      validNum = true;
	      return true;
	    }
	    
	    window.onload = function() {
	        <?php if (!$is_logged_in): ?>
	        alert("Silahkan Login terlebih dahulu untuk memesan!");
	        <?php endif; ?>
	    };
	    
	    function validateForm(el){
	        if (!validNum) {
	            return false;
	        }
	        <?php if (!$is_logged_in): ?>
	        alert("Silahkan Login terlebih dahulu untuk memesan!");
	        return false;
	        <?php endif; ?>
	        return true;
	    }
	</script>

</body>

</html>