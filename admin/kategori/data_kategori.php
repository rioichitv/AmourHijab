<table class="table table-bordered" id="table">
	<thead>
		<tr>
			<th>
				No
			</th>
			<th>
				Nama Kategori
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
		//Untuk Mengambil Data Kategori
		$data = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY id_kategori DESC");
		while ($row = mysqli_fetch_array($data)) {
			?>
			<tr>
				<td>
					<?php echo $no++; ?>
				</td>
				<td>
					<?php echo $row['nama_kategori']; ?>
				</td>
				<td>
					<a href="#" class="btn btn-primary" id="edit" data-id="<?php echo $row['id_kategori']; ?>">Ubah</a> |
					<button type="button" id="confirm_delete" class="btn btn-danger"
						data-id="<?php echo $row['id_kategori']; ?>">Hapus</button>
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