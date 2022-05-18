<?php
$kode = 0;
if (isset($_GET['kode'])) {
	$kode = $_GET['kode'];
}
?>
<style type="text/css">
	#chart-suara {
		width: 100%;
		height: 10;
	}

	#chart-bar {
		width: 100%;
		height: 10;
	}
</style>

<script>
	//pie chart
	$(document).ready(function() {
		var options = {

			chart: {
				type: 'pie',
				renderTo: 'chart-suara',
				options3d: {
					enabled: true,
					alpha: 45,
					beta: 0
				}
			},
			title: {
				text: 'Chart Perolehan Suara'
			},
			accessibility: {
				point: {
					valueSuffix: '%'
				}
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					depth: 35,
					dataLabels: {
						enabled: true,
						format: '{point.name}'
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Browser share',
				data: []
			}]

		}


		$.getJSON("./admin/suara/chart_suara.php?kode=<?php echo $kode; ?>", function(json) {
			options.series[0].data = json;


			chart = new Highcharts.Chart(options);
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		//bar chart
		var options = {
			chart: {
				renderTo: 'chart-bar',
				type: 'column',
				options3d: {
					enabled: true,
					alpha: 15,
					beta: 15,
					depth: 50,
					viewDistance: 25
				}
			},
			title: {
				text: 'Jumlah Perolehan Suara',
				x: -20 //center
			},
			subtitle: {
				text: 'Seluruh Data',
				x: -20
			},
			xAxis: {
				categories: []
			},
			yAxis: {
				title: {
					text: 'Jumlah'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080'
				}]
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: '{point.y}'
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'top',
				x: -40,
				y: 100,
				floating: true,
				borderWidth: 1,
				backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
				shadow: true
			},
			series: []
		};

		$.getJSON("./admin/suara/bar_suara.php?kode=<?php echo $kode; ?>", function(json) {
			//alert(json);
			options.xAxis.categories = json[0]['data']; //xAxis: {categories: []}
			options.series[0] = json[1];
			chart = new Highcharts.Chart(options);
		});
	});
</script>

<style>
	p.normal {
		font-size: 12;
		font-weight: bold;
	}
</style>

<?php
$sql = $koneksi->query("SELECT COUNT(ID_CALON) as tot_calon  from tb_votekandidat where flag_id=1");
while ($data = $sql->fetch_assoc()) {
	$calon = $data['tot_calon'];
}

$sql = $koneksi->query("SELECT COUNT(daftarvote_id) as tot_vote  from tb_daftarvote where flag_id=1 and status_id='1'");
while ($data = $sql->fetch_assoc()) {
	$tot_vote = $data['tot_vote'];
}

$sql = $koneksi->query("SELECT COUNT(id_pemilih) as sudah  from tb_votepemilih where status_id='2' and flag_id=1");
while ($data = $sql->fetch_assoc()) {
	$sudah = $data['sudah'];
}

$sql = $koneksi->query("SELECT COUNT(id_pemilih) as belum  from tb_votepemilih where status_id='1' and flag_id=1");
while ($data = $sql->fetch_assoc()) {
	$belum = $data['belum'];
}
?>

<div class="row">
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-info">
			<div class="inner">
				<h3>
					<?php echo $calon; ?>
				</h3>

				<p>Jumlah Kandidat</p>
			</div>
			<div class="icon">
				<i class="ion ion-stats-bars"></i>
			</div>
			<a href="?page=data-calon" class="small-box-footer">Selengkapnya
				<i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->

	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-yellow">
			<div class="inner">
				<h3><?php echo $tot_vote; ?></h3>

				<p>Jumlah Vote Aktif</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="?page=data-daftarvote" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3>
					<?php echo $sudah; ?>
				</h3>

				<p>Sudah Memilih</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="?page=data-daftarvote" class="small-box-footer">Selengkapnya
				<i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-danger">
			<div class="inner">
				<h3>
					<?php echo $belum; ?>
				</h3>

				<p>Belum Memlih</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
			<a href="?page=data-daftarvote" class="small-box-footer">Selengkapnya
				<i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>
</div>


<?php
//list data daftar vote
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

<script>
	function DaftarVote(value) {
		var url = 'index.php?&kode=' + value;
		window.location = url;
	}
</script>

<div class="row">
	<div class="col">
		<!-- Area Chart Example-->
		<div class="card">
			<div class="card-header">
				<i class="fa fa-pie-chart"></i> Persentase Perolehan Suara
			</div>
			<div class="card-body">
				<div id="chart-suara" width="100%" height="20%">
					<canvas id="chart-suara" width="100%" height="20"></canvas>
				</div>
				<!-- <canvas id="myAreaChart" width="100%" height="30"></canvas> -->
			</div>
			<div class="card-footer small text-muted">Updated : <?php echo date('d-m-Y H:i'); ?></div>
		</div>

		<div class="card">
			<div class="card-header">
				<i class="fa fa-bar-chart"></i> Grafik Peroleh Suara
			</div>
			<div class="card-body">
				<div id="chart-bar" width="100%" height="20%">
					<canvas id="chart-bar" width="100%" height="20"></canvas>
				</div>
				<!-- <canvas id="myAreaChart" width="100%" height="30"></canvas> -->
			</div>
			<div class="card-footer small text-muted">Updated : <?php echo date('d-m-Y H:i'); ?></div>
		</div>
	</div>
</div>