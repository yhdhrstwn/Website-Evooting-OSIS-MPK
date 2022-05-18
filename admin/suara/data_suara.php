<?php
if (isset($_GET['kode'])) {
	$kode = $_GET['kode'];
	//$kode = $_GET['kode'];
} else {
	$kode = 0;
}
//echo $_SESSION['KODE'];
include dirname(__FILE__) . '/../../inc/koneksi.php';
$query = "select b.daftarvote_id, a.*, coalesce(c.jumlah,0) jumlah 
from tb_votekandidat b 
left join tb_calon a on a.id_calon=b.id_calon
left join (select id_calon, daftarvote_id, count(id_vote) jumlah 
from tb_vote where daftarvote_id=" . $kode . " group by id_calon, daftarvote_id) c on a.id_calon=c.id_calon
where b.flag_id<>9 and b.daftarvote_id=" . $kode . " order by jumlah desc";
//echo $query;
$sql = $koneksi->query($query);

?>
<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-fa-vote-yea"></i> Daftar Vote
		</h3>
	</div>
	<select name="daftar_vote" id="daftar_vote" class="form-control" onchange="DaftarVote(this.value)">
		<option value="0">- Pilih -</option>
		<?php
		$sql1 = "select * from tb_daftarvote where status_id='1' and flag_id=1";
		$row = $koneksi->query($sql1);
		//echo $kode;
		while ($result = $row->fetch_assoc()) {
			if ($kode  != $result['daftarvote_id']) {
				$selected = "";
			} else {
				$selected = "selected";
			}
			echo '<option value="' . $result['daftarvote_id'] . '" ' . $selected . '>' . $result['nama'] . '</option>';
		}

		//include_once dirname(__FILE__) . '/../../inc/koneksi.php';
		$no = 1;

		?>
	</select>
</div>


<!--
<div class="realtime">
		<div class="card card-info autoload">
-->
<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-chart-pie"></i> Perolehan Suara
		</h3>
	</div>
	<!-- /.card-header -->
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>No Urut</th>
						<th>Nama Kandidat</th>
						<th>
							<center>Foto Kandidat</center>
						</th>
						<th>Keterangan</th>
						<th>Jumlah Suara</th>
					</tr>
				</thead>
				<tbody>

					<?php

					while ($data = $sql->fetch_assoc()) {

						$id_calon = $data["id_calon"];
					?>

						<tr>
							<td>
								<?php echo $no++; ?>
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
								<h4>
									<?php

									echo $data['jumlah'] . " Suara";

									?>
								</h4>
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
<!-- /.card-body -->
<!--	</div>
					-->

<script>
	function DaftarVote(value) {
		var url = '?page=data-suara&kode=' + value;
		//	alert(url);
		window.location = url;
	}
</script>