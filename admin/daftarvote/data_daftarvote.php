<!-- /.card-header -->
<div class="card-body">
	<div class="table-responsive">
		<div>
			<a href="?page=add-daftarvote" class="btn btn-primary">
				<i class="fa fa-edit"></i> Tambah Data</a>
		</div>
		<br>
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama Vote</th>
					<th>Keterangan</th>
					<th>Tanggal Mulai</th>
					<th>Tanggal Selesai</th>
					<th>Jumlah Calon</th>
					<th>Jumlah Pemilih</th>
					<th>Status</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>

				<?php
				$_SESSION['URL'] = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1, strlen($_SERVER['REQUEST_URI']));
				$no = 1;
				$sql = $koneksi->query("
					select a.*, jumlah_calon, jumlah_pemilih, coalesce(sudah_memilih,0) sudah_memilih, 
					coalesce(belum_memilih,0) belum_memilih from tb_daftarvote a
					left join 
					
					(select daftarvote_id, count(*) jumlah_calon 
					from tb_votekandidat where flag_id<>9 group by daftarvote_id) b
					on a.daftarvote_id=b.daftarvote_id
					left join (select daftarvote_id, count(*) jumlah_pemilih, 
					sum(case when status_id=2 then 1 else 0 end) sudah_memilih, 
					sum(case when status_id=1 then 1 else 0 end)  belum_memilih 
					from tb_votepemilih where flag_id<>9 group by daftarvote_id) c

					on a.daftarvote_id=c.daftarvote_id
					where a.flag_id<>9");
				while ($data = $sql->fetch_assoc()) {
				?>

					<tr>
						<td>
							<?php echo $no++; ?>
						</td>
						<td>
							<?php echo $data['nama']; ?>
						</td>
						<td>
							<?php echo $data['keterangan']; ?>
						</td>
						<td>
							<?php echo date('d-m-Y H:i a', strtotime($data['tanggal_mulai'])); ?>
						</td>
						<td>
							<?php echo date('d-m-Y H:i a', strtotime($data['tanggal_selesai'])); ?>
						</td>
						<td align="right">
							<?php echo $data['jumlah_calon']; ?>
						</td>
						<td>
							<div style="font-size:20px"><span class="badge badge-success">sudah memilih : <?php echo $data['sudah_memilih']  ?></span></div>
							<div style="font-size:20px"> <span class="badge badge-danger">belum memilih : <?php echo $data['belum_memilih']  ?></span></div>
							<div style="font-size:20px"><span class="badge badge-primary">total pemilih : <?php echo $data['jumlah_pemilih'] ?> </span></div>

						</td>
						<td>
							<?php $stt = $data['status_id']  ?>
							<?php switch ($stt) {
								case '1':
							?>
									<span class="badge badge-success">Aktif</span>
								<?php
									break;
								case '0':
								?>
									<span class="badge badge-danger">Inaktif</span>
								<?php
									break;
								case '2':
								?>
									<span class="badge badge-secondary">Tutup</span>
						</td>
				<?php
									break;
							} ?>
				</td>
				<td>
					<a href="?page=data-daftardetailvote&kode=<?php echo $data['daftarvote_id']; ?>" title="Detail" class="btn btn-primary btn-sm">
						<i class="fa fa-search"></i>
					</a>
					<a href="?page=edit-daftarvote&kode=<?php echo $data['daftarvote_id']; ?>" title="Ubah" class="btn btn-success btn-sm">
						<i class="fa fa-edit"></i>
					</a>
					<a href="?page=del-daftarvote&kode=<?php echo $data['daftarvote_id']; ?>" onclick="return confirm('Hapus Data Ini ?')" title="Hapus" class="btn btn-danger btn-sm">
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