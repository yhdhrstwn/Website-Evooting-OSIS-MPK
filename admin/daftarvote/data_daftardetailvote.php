<?php
$kode =  isset($_GET['kode']) ? $_GET['kode'] : 0;
include dirname(__FILE__) . '/../../inc/koneksi.php';
//$filename = dirname(__FILE__);

$sql = "select * from tb_daftarvote where status_id='1' and daftarvote_id=" . $kode;
$data = $koneksi->query($sql);
$row = $data->fetch_array(MYSQLI_ASSOC);
$nama = $row['nama'];
?>

<div>
	<a href="<?php echo $_SESSION['URL']; ?>" class="btn btn-secondary btn-sm">
		<< Kembali</a>
</div>
<p>
<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-table"></i> <?php echo $nama ?>
		</h3>
	</div>

</div>

<div class="card card-info">

	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#kandidat">Kandidat</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#pemilih">Pemilih</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div id="kandidat" class="container tab-pane active"><br>
			<div class="card-header">
				<h3 class="card-title">
					<i class="fa fa-table"></i> Data Kandidat Vote
				</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="table-responsive">
					<div>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_calon">
							Tambah Data
						</button>
						<button type="button" class="btn btn-danger" data-toggle="modal" onclick="HapusSemuaCalon(<?php echo $kode; ?>)">
							Hapus Semua Data
						</button>
						<button type="button" onclick="SetNomorUrut(<?php echo $kode; ?>)" class="btn btn-warning" data-toggle="modal">
							Set No Urut
						</button>
						<button type="button" onclick="TutupKandidat(<?php echo $kode; ?>)" class="btn btn-success" data-toggle="modal">
							Refresh
						</button>
					</div>
					<br>
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No Urut</th>
								<th>Nama Kandidat</th>
								<th>Foto</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$no = 1;
							$query = "select a.votekandidat_id, a.daftarvote_id, b.nama_calon, b.keterangan, 
							b.id_calon, b.foto_calon, a.no_urut from tb_votekandidat a
							join tb_calon b on a.id_calon=b.id_calon 
							where a.flag_id=1 and b.status='1' and a.daftarvote_id=" . $kode;
							$sql = $koneksi->query($query);
							while ($data = $sql->fetch_assoc()) {
							?>

								<tr>
									<td>
										<?php echo $data['no_urut']; ?>
									</td>
									<td>
										<?php echo $data['nama_calon']; ?>
									</td>
									<td align="center">
										<img src="foto/<?php echo $data['foto_calon']; ?>" width="50px" />
									</td>
									<td style="white-space:pre-line">
										<?php echo $data['keterangan']; ?>
									<td>
										<?php
										$qry = "select id_vote jumlah 
										from tb_vote where daftarvote_id=" . $kode .
											" and id_calon=" . $data['id_calon'];
										//echo $qry;
										$sql1 = $koneksi->query($qry);
										$jumlah = mysqli_num_rows($sql1);
										if ($jumlah == 0) {
										?>
											<a href="?page=action-detailvote&action=deletecalon&kode=<?php echo $kode ?>&id=<?php echo $data['id_calon']; ?>" onclick="return confirm('Hapus Data Ini ?')" title="Hapus" class="btn btn-danger btn-sm">
												<i class="fa fa-trash"></i>
											</a>
										<?php } ?>
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
		</div>

		<div id="pemilih" class="container tab-pane fade"><br>
			<div class="card-header">
				<h3 class="card-title">
					<i class="fa fa-table"></i> Data Pemilih Vote
				</h3>
			</div>
			<!-- /.card-header -->
			<div class="card-body">
				<div class="table-responsive">
					<div>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#form_pemilih">
							Tambah Data
						</button>
						<button type="button" class="btn btn-danger" data-toggle="modal" onclick="HapusSemuaPemilih(<?php echo $kode; ?>)">
							Hapus Semua Data
						</button>
						<button type="button" onclick="TutupKandidat(<?php echo $kode; ?>)" class="btn btn-success" data-toggle="modal">
							Refresh
						</button>
					</div>
					<br>
					<table id="example3" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Pemilih</th>
								<th>Username</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$no = 1;
							$sql = $koneksi->query(
								"select a.votepemilih_id, a.daftarvote_id, b.id_pengguna, 
								b.nama_pengguna, b.username, a.status_id
								 from tb_votepemilih a
							join tb_pengguna b on a.id_pemilih=b.id_pengguna
							where a.flag_id=1 and b.status='1' and a.daftarvote_id=" . $kode
							);
							while ($data = $sql->fetch_assoc()) {
							?>

								<tr>
									<td>
										<?php echo $no++; ?>
									</td>
									<td>
										<?php echo $data['nama_pengguna']; ?>
									</td>
									<td>
										<?php echo $data['username']; ?>
									</td>
									<td>
										<?php $stt = $data['status_id'];
										if ($stt == '1') {

										?>
											<span class="badge badge-warning">Belum memilih</span>
										<?php } elseif ($stt == '2') {

										?>
											<span class="badge badge-success">Sudah memilih</span>
									</td>
								<?php } ?>
								<td>
									<?php if ($stt == '1') { ?>
										<a href="?page=action-detailvote&action=deletepemilih&kode=<?php echo $kode ?>&id=<?php echo $data['id_pengguna']; ?>" onclick="return confirm('Hapus Data Ini ?')" title="Hapus" class="btn btn-danger btn-sm">
											<i class="fa fa-trash"></i>
										</a>
									<?php } ?>
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

		</div>

	</div>

	<div class="modal fade" tabindex="-1" role="dialog" id="form_calon">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Daftar Kandidat (Calon)</h5>
				</div>
				<div class="modal-body">
					<div>
						<p>
							<button type="button" class="btn btn-primary" data-toggle="modal" onclick="TambahSemuaCalon(<?php echo $kode ?>)">
								Tambah Semua Data
							</button>
						</p>
					</div>
					<table id="example4" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Kandidat</th>
								<th>Foto</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$no = 1;
							$query = "select * from tb_calon 
							where status='1' and id_calon not in 
							(select id_calon from tb_votekandidat where flag_id<>9 and daftarvote_id=" . $kode . ")";
							//echo $query;
							$sql = $koneksi->query($query);

							while ($data = $sql->fetch_assoc()) {
							?>

								<tr>
									<td>
										<?php echo $no++; ?>
									</td>
									<td>
										<?php echo $data['nama_calon']; ?>
									</td>
									<td align="center">
										<img src="foto/<?php echo $data['foto_calon']; ?>" width="50px" />
									</td>

									<td>
										<button onclick="TambahCalon(<?php echo $kode; ?>,<?php echo $data['id_calon']; ?>)" id="btn_tambahcalon<?php echo $data['id_calon']; ?>" class="btn btn-success btn-sm">
											<i class="fa fa-edit"></i>
										</button>
									</td>
								</tr>

							<?php
							}

							?>
						</tbody>
						</tfoot>
					</table>
				</div>
				<div class="modal-footer">

					<button type="button" class="btn btn-secondary" onclick="TutupKandidat(<?php echo $kode ?>)" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" tabindex="-1" role="dialog" id="form_pemilih">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Daftar Pemilih</h5>
				</div>
				<div class="modal-body">
					<div>
						<p>
							<button type="button" class="btn btn-primary" data-toggle="modal" onclick="TambahSemuaPemilih(<?php echo $kode ?>)">
								Tambah Semua Data
							</button>
						</p>
					</div>
					<table id="example5" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Pemilih</th>
								<th>Username</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>

							<?php
							$no = 1;
							$query = "select * from tb_pengguna 
							where status='1' and jenis='pst' and id_pengguna not in 
							(select id_pemilih from tb_votepemilih where flag_id<>9 and daftarvote_id=" . $kode . ")";
							//echo $query;
							$sql = $koneksi->query($query);

							while ($data = $sql->fetch_assoc()) {
							?>

								<tr>
									<td>
										<?php echo $no++; ?>
									</td>
									<td>
										<?php echo $data['nama_pengguna']; ?>
									</td>
									<td>
										<?php echo $data['username']; ?>
									</td>
									<td>
										<button onclick="TambahPemilih(<?php echo $kode; ?>,<?php echo $data['id_pengguna']; ?>)" id="btn_tambahpemilih<?php echo $data['id_pengguna']; ?>" class="btn btn-success btn-sm">
											<i class="fa fa-edit"></i>
										</button>
									</td>
								</tr>

							<?php
							}

							?>
						</tbody>
						</tfoot>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" onclick="TutupKandidat(<?php echo $kode ?>)" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		function TambahCalon(value, value2) {
			var url = '?page=action-detailvote&action=insertcalon&kode=' + value + '&id=' + value2;
			$.post(url).done();
			$('#btn_tambahcalon' + value2).prop('disabled', true);
		}

		function TambahSemuaCalon(value) {
			var url = '?page=action-detailvote&action=insertallcalon&kode=' + value + '&id=0';
			$.post(url).done(
				window.location = 'index.php?page=data-daftardetailvote&kode=' + value
			);
		}

		function HapusSemuaCalon(value) {
			var r = confirm('Hapus semua data?');
			if (r == true) {
				var url = '?page=action-detailvote&action=deleteallcalon&kode=' + value + '&id=0';
				$.post(url).done(
					window.location = 'index.php?page=data-daftardetailvote&kode=' + value
				);
			}
		}


		function TambahPemilih(value, value2) {
			var url = '?page=action-detailvote&action=insertpemilih&kode=' + value + '&id=' + value2;
			$.post(url).done();
			$('#btn_tambahpemilih' + value2).prop('disabled', true);
		}

		function TambahSemuaPemilih(value) {
			var url = '?page=action-detailvote&action=insertallpemilih&kode=' + value + '&id=0';
			$.post(url).done(
				window.location = 'index.php?page=data-daftardetailvote&kode=' + value
			);
		}

		function HapusSemuaPemilih(value) {
			var r = confirm('Hapus semua data?');
			if (r == true) {
				var url = '?page=action-detailvote&action=deleteallpemilih&kode=' + value + '&id=0';
				$.post(url).done(
					window.location = 'index.php?page=data-daftardetailvote&kode=' + value
				);
			}
		}

		function SetNomorUrut(value) {
			var url = '?page=action-detailvote&action=setnomorurut&kode=' + value + '&id=0';
			$.post(url).done(
				window.location = 'index.php?page=data-daftardetailvote&kode=' + value);
		}

		function TutupKandidat(value) {
			window.location = 'index.php?page=data-daftardetailvote&kode=' + value
		}
	</script>