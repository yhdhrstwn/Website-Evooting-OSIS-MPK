<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-table"></i> Data Kandidat
		</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<div class="table-responsive">
			<div>
				<a href="?page=add-calon" class="btn btn-primary">
					<i class="fa fa-edit"></i> Tambah Data</a>
			</div>
			<br>
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No Urut</th>
						<th>Nama Kandidat</th>
						<th>Foto Kandidat</th>
						<th>Keterangan</th>
						<th>Status</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>

					<?php
					$no = 1;
					$sql = $koneksi->query("select * from tb_calon order by nama_calon");
					while ($data = $sql->fetch_assoc()) {
					?>

						<tr>
							<td>
								<?php echo $data['id_calon']; ?>
							</td>
							<td>
								<?php echo $data['nama_calon']; ?>
							</td>
							<td align="center">
								<img src="foto/<?php echo $data['foto_calon']; ?>" width="150px" />
							</td>
							<td style="white-space:pre-line">
								<?php echo $data['keterangan']; ?>
							</td>
							<td>
								<?php $stt = $data['status']  ?>
								<?php if ($stt == '1') { ?>
									<span class="badge badge-success">Aktif</span>
								<?php } elseif ($stt == '0') { ?>
									<span class="badge badge-danger">Inaktif</span>
							</td>
						<?php } ?>
						<td>
							<a href="?page=edit-calon&kode=<?php echo $data['id_calon']; ?>" title="Ubah" class="btn btn-success btn-sm">
								<i class="fa fa-edit"></i>
							</a>
							<a href="?page=del-calon&kode=<?php echo $data['id_calon']; ?>" onclick="return confirm('Apakah anda yakin hapus data ini ?')" title="Hapus" class="btn btn-danger btn-sm">
								<i class="fa fa-trash"></i>
							</a>
						</td>
						</tr>

					<?php
					}
					?>
				</tbody>
				</tfoot>
			</table>
		</div>
	</div>
	<!-- /.card-body -->
	<script>
		$(document).ready(function() {

			$('#example').DataTable({
				"dom": 'Bfrtip',
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				"buttons": [
					'excelHtml5'

				]
			});

		});
	</script>