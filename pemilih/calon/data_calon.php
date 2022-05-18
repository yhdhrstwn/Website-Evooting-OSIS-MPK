<div class="form-group row">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-fa-vote-yea"></i> Daftar Vote
		</h3>
		<?php
		if (isset($_GET['kode'])) {
			$kode = $_GET['kode'];
		} else {
			$kode = 0;
		}
		?>
		<select name="daftar_vote" id="daftar_vote" class="form-control" onchange="DaftarVote(this.value)">
			<option value="-1">- Pilih -</option>
			<?php
			$sql = "select distinct a.* from tb_daftarvote a
			join tb_votepemilih b on a.daftarvote_id=b.daftarvote_id
			where a.flag_id=1 and a.status_id='1' and (now() between tanggal_mulai and tanggal_selesai)  
			and b.id_pemilih=" . $data_id;

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

<script>
	function DaftarVote(value) {
		var url = '?page=PsSQAdT&kode=' + value;
		//alert(url);
		window.location = url;
	}
</script>

<?php
$_SESSION['URL'] = substr($_SERVER['REQUEST_URI'], strrpos($_SERVER['REQUEST_URI'], '/') + 1, strlen($_SERVER['REQUEST_URI']));
$data_id = $_SESSION["ses_id"];
$query = "select * from tb_votepemilih where daftarvote_id=" . $kode . " and id_pemilih=" . $data_id;
//echo $query;
//$sql = $koneksi->query("select * from tb_pengguna where id_pengguna=$data_id");
$sql = $koneksi->query($query);
$rowcount = mysqli_num_rows($sql);
//echo $rowcount;
$status = -1;
//echo $kode;
if (($rowcount == 0) && ($kode != -1)) {
	$status = 0;
} else {
	while ($data = $sql->fetch_assoc()) {
		$status = $data['status_id'];
	}
}

switch ($status) {
	case ($status === '0') || ($status === '1'): { ?>
			<?php
			$sql = $koneksi->query("select b.*, a.no_urut, a.daftarvote_id from tb_votekandidat a 
					join tb_calon b on a.id_calon=b.id_calon 
					where a.flag_id<>9 and daftarvote_id=" . $kode);
			$jumlah = mysqli_num_rows($sql);
			if ($jumlah == 0) {
			?>
				<div class="alert alert-info alert-warning">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4>
						<i class="icon fas fa-info"></i>Info
					</h4>
					<h3>Belum ada data calon. Silahkan masukan data calon terlebih dahulu!</h3>
				</div>
			<?php
			} else {
			?>
				<div class="col-12">
					<div class="card-header">
						<h3 class="card-title">
							<i class="fa fa-fa-vote-yea">
								<div id="demo" style="text-align: center; font-size: 40px; "></div>
							</i>
						</h3>
					</div>
				</div>
				<div id="datacalon">
					<div class="row">
						<tbody>
							<?php
							while ($data = $sql->fetch_assoc()) {
							?>
								<!-- Profile Image -->

								<div class="col-md-4">
									<div class="card card-primary card-outline">
										<div class="card-body">
											<h4 class="profile-username text-center">
												<?php echo $data['no_urut']; ?>
											</h4>
											<div class="text-center">
												<img src="foto/<?php echo $data['foto_calon']; ?>" width="235px" />
											</div>

											<h3 class="profile-username text-center">
												<?php echo $data['nama_calon']; ?>
											</h3>
												<center>
													<a href="?page=view&kode=<?php echo $data['id_calon']; ?>" class="btn btn-success btn-sm">
														<i class="fa fa-file"></i> Visi & Misi
													</a>
													<?php if ($status == 1) { ?>
														<a href="?page=PsSQBBK&kode=<?php echo $data['id_calon']; ?>&id=<?php echo $data['daftarvote_id']; ?>" id="btn<?php echo $data['id_calon']; ?>" class="btn btn-primary">
															<i class="fa fa-edit"></i> Coblos
														</a>
													<?php } ?>
												</center>
										</div>
									</div>
								</div>

								<!-- /.card -->
							<?php
							}
							?>
						</tbody>
					</div>
				</div>
			<?php
			}
			?>


			<!-- /.card-body -->
		<?php
			break;
		}
	case '2': { ?>

			<div class="alert alert-info alert-default-dark">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4>
					<i class="icon fas fa-info"></i>Info
				</h4>
				<h3>Anda sudah menggunakan Hak Suara dengan baik, Terimakasih.</h3>
			</div>
		<?php
			break;
		}
	case '-1': { ?>
			<div class="alert alert-info alert-primary">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4>
					<i class="icon fas fa-info"></i>Info
				</h4>
				<h3>Pilih daftar vote terlebih dahulu! Terimakasih.</h3>
			</div>
<?php
			break;
		}
}
