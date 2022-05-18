<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-table"></i> Kotak Suara
		</h3>
	</div>
	<?php

	if (isset($_GET['kode'])) {
		$kode = $_GET['kode'];
	} else {
		$kode = 0;
	}
	?>
	<div class="form-group row">
		<div class="card-header">
			<h3 class="card-title">
				<i class="fa fa-fa-vote-yea"></i> Daftar Vote
			</h3>


			<select name="daftar_vote" id="daftar_vote" class="form-control" onchange="DaftarVote(this.value)">
				<option value="0">- Pilih -</option>
				<?php
				$sql = "select * from tb_daftarvote where status_id='1' and flag_id=1";
				$row = $koneksi->query($sql);
				//echo $kode;
				while ($data = $row->fetch_assoc()) {
					//$id = $data['daftarvote_id'];
					//	echo '<p>data id=' . $id . '</p>';
					//	echo '<p>data kode=' . $kode . '</p>';
					if ($kode != $data['daftarvote_id']) {
						$selected = "";
					} else {
						$selected = "selected";
					}
					echo '<option value="' . $data['daftarvote_id'] . '" ' . $selected . '>' . $data['nama'] . '</option>';
				}
				?>
			</select>

		</div>
	</div>

	<!-- /.card-header -->
	<div class="card-body">
		<div class="table-responsive">
			<table id="data_kotak" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Pemilih</th>
						<th>Username</th>
						<th>Waktu Memilih</th>
					</tr>
				</thead>
				<tbody>

					<?php
					$no = 1;
					$sql = $koneksi->query("select `a`.`id_vote` AS `id_vote`,`a`.`daftarvote_id` AS `daftarvote_id`,
					`a`.`id_calon` AS `id_calon`,`a`.`id_pemilih` AS `id_pemilih`,`a`.`date` AS `date`,
					`b`.`nama_calon` AS `nama_calon`,`b`.`foto_calon` AS `foto_calon`,`b`.`keterangan` AS `keterangan`,
					`c`.`nama_pengguna` AS `nama_pemilih`, c.username 
					from `tb_vote` `a` join `tb_calon` `b` on `a`.`id_calon` = `b`.`id_calon`
					join `tb_pengguna` `c` on `a`.`id_pemilih` = `c`.`id_pengguna` 
					where a.daftarvote_id=" .  $kode . " order by date desc, nama_pemilih");
					while ($data = $sql->fetch_assoc()) {
					?>

						<tr>
							<td>
								<?php echo $no++; ?>
							</td>
							<td>
								<?php echo $data['nama_pemilih']; ?>
							</td>
							<td>
								<?php echo $data['username']; ?>
							</td>
							<td>
								<?php echo $data['date']; ?>
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
		function DaftarVote(value) {
			var url = '?page=data-kotak&kode=' + value;
			window.location = url;
		}
	</script>