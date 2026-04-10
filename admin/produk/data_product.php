<table class="table table-bordered" id="table">
	<thead>
		<tr>
			<th>
				No
			</th>
			<th>
				Nama
			</th>
			<th>
				Harga
			</th>
			<th>
				Deskripsi
			</th>
			<th>
				Stok
			</th>
			<th>
				Kategori
			</th>
			<th>
				Gambar
			</th>
			<th>
				Opsi
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		include '../includer.php';
		$no   = 1;
		$data = mysqli_query($koneksi, "SELECT * FROM tb_barang LEFT JOIN tb_kategori ON tb_kategori.id_kategori = tb_barang.id_kategori ORDER BY id_barang DESC");
		while ($row = mysqli_fetch_array($data)) {
			?>
			<tr>
				<td>
					<?php echo $no++; ?>
				</td>
				<td>
					<?php echo $row['nama_barang']; ?>
				</td>
				<td>
					Rp.
					<?php echo number_format($row['harga_barang']); ?>
				</td>
				<td>
					<?php echo substr($row['deskripsi_barang'], 0, 40); ?>...
				</td>
				<td>
					<?php echo $row['stok_barang']; ?>
				</td>
				<td>
					<?php echo $row['nama_kategori']; ?>
				</td>
				<td>
					<img src="<?= base_url(); ?>assets/produk/<?php echo $row['foto_barang']; ?>" width="100px"
						height="100px">
				</td>
				<td>
					<a href="#" class="btn btn-primary" id="edit" data-id="<?php echo $row['id_barang']; ?>">Ubah</a> |
					<button type="button" id="confirm_delete" class="btn btn-danger"
						data-id="<?php echo $row['id_barang']; ?>">Hapus</button>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

<script src="../docs/js/plugins/jquery.dataTables.min.js"></script>
<script src="../docs/js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">$('#table').DataTable();</script>