<?php
//Mulai Sesion
session_start();
if (isset($_SESSION["ses_username"]) == "") {
	header("location: login");
} else {
	$data_id = $_SESSION["ses_id"];
	$data_nama = $_SESSION["ses_nama"];
	$data_user = $_SESSION["ses_username"];
	$data_level = $_SESSION["ses_level"];
	$data_status = $_SESSION["ses_status"];
	$data_jenis = $_SESSION["ses_jenis"];
}

//KONEKSI DB
include "inc/koneksi.php";

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Pemilihan Ketua OSIS & MPK</title>
	<link rel="icon" href="dist/img/smkbpm.png">
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/css/buttons.dataTables.min.css">

	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="plugins/css/ionicons.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="dist/css/adminlte.min.css">
	<!-- Select2 -->
	<link rel="stylesheet" href="plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="stylesheet" href="plugins/css/icon.css">
	<!-- Alert -->
	<script src="plugins/alert.js"></script>
	<!-- Auto Refresh  -->
	<script src="plugins/jquery/jquery.js" type="text/javascript"></script>
	<link rel="shortcut icon" href="dist/img/smkbpm.png" />
	<link rel="stylesheet" href="plugins/highcharts/code/highcharts.css">


	<script>
		setInterval(function() {
			$(".realtime").load("admin/suara/data_suara.php").fadeIn("slow");
		}, 1000);
	</script>
</head>

<body class="hold-transition sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand navbar-green navbar-light">
			<!-- Left navbar links -->
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" data-widget="pushmenu" href="#">
						<i class="fas fa-bars"></i>
					</a>
				</li>

			</ul>

			<!-- SEARCH FORM -->
			<ul class="navbar-nav ml-auto">

				<li class="nav-item d-none d-sm-inline-block">
					<a href="index.php" class="nav-link">
						<b>SMKBPMVotingv.0.1</b>
					</a>
				</li>
			</ul>

		</nav>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-light-primary elevation-4">
			<!-- Brand Logo -->
			<a href="index.php" class="brand-link">
				<img src="dist/img/osis&mpk.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8">
				<span class="brand-text font-weight-light"> OSIS & MPK</span>
			</a>

			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Sidebar user (optional) -->
				<div class="user-panel mt-3 pb-3 mb-3 d-flex">
					<div class="image">
						<img src="dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
					</div>
					<div class="info">
						<a href="index.php" class="d-block">
							<?php echo $data_nama; ?>
						</a>
						<span class="badge badge-success">
							<?php echo $data_level; ?>
						</span>
					</div>
				</div>

				<!-- Sidebar Menu -->
				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						<!-- Level  -->
						<?php
						if ($data_level == "Administrator") {
						?>
							<li class="nav-item">
								<a href="index.php" class="nav-link">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>
										Dashboard
									</p>
								</a>
							</li>

							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-cogs"></i>
									<p>
										Master Data
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="?page=data-calon" class="nav-link">
											<i class="nav-icon far fa-circle text-success"></i>
											<p>Data Kandidat</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="?page=data-pemilih" class="nav-link">
											<i class="nav-icon far fa-circle text-success"></i>
											<p>Data Pemilih</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="?page=data-daftarvote" class="nav-link">
											<i class="nav-icon far fa-circle text-success"></i>
											<p>Data Daftar Vote</p>
										</a>
									</li>
								</ul>
							</li>

							<li class="nav-item">
								<a href="?page=PsSQAdT&kode=-1" class="nav-link">
									<i class="nav-icon far fa fa-edit"></i>
									<p>
										Bilik Suara
									</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="?page=data-kotak" class="nav-link">
									<i class="nav-icon far fa fa-table"></i>
									<p>
										Kotak Suara
									</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="?page=data-suara" class="nav-link">
									<i class="nav-icon far fa fa-chart-pie"></i>
									<p>
										Hitung Cepat
										<span class="badge badge-primary">
											HC
										</span>
									</p>
								</a>
							</li>


							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-file"></i>
									<p>
										Laporan
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="?page=laporan-calon" class="nav-link">
											<i class="nav-icon far fa-circle text-info"></i>
											<p>Daftar Kandidat</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="?page=laporan-pemilih" class="nav-link">
											<i class="nav-icon far fa-circle text-info"></i>
											<p>Daftar pemilih</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="?page=laporan-vote" class="nav-link">
											<i class="nav-icon far fa-circle text-info"></i>
											<p>Daftar Voting</p>
										</a>
									</li>
								</ul>
							</li>

							<li class="nav-header">Setting</li>
							<li class="nav-item">
								<a href="?page=data-pengguna" class="nav-link">
									<i class="nav-icon far fa-user"></i>
									<p>
										Users
									</p>
								</a>
							</li>

						<?php
						} elseif ($data_level == "Petugas") {
						?>

							<li class="nav-item">
								<a href="index.php" class="nav-link">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>
										Dashboard
									</p>
								</a>
							</li>

							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-cogs"></i>
									<p>
										Master Data
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="?page=data-calon" class="nav-link">
											<i class="nav-icon far fa-circle text-success"></i>
											<p>Data Kandidat</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="?page=data-pemilih" class="nav-link">
											<i class="nav-icon far fa-circle text-success"></i>
											<p>Data Pemilih</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="?page=data-daftarvote" class="nav-link">
											<i class="nav-icon far fa-circle text-success"></i>
											<p>Data Daftar Vote</p>
										</a>
									</li>
								</ul>
							</li>

							<li class="nav-item">
								<a href="?page=data-kotak" class="nav-link">
									<i class="nav-icon far fa fa-table"></i>
									<p>
										Kotak Suara
									</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="?page=data-suara" class="nav-link">
									<i class="nav-icon far fa fa-chart-pie"></i>
									<p>
										Hitung Cepat
										<span class="badge badge-primary">
											HC
										</span>
									</p>
								</a>
							</li>


							<li class="nav-item has-treeview">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-file"></i>
									<p>
										Laporan
										<i class="fas fa-angle-left right"></i>
									</p>
								</a>
								<ul class="nav nav-treeview">
									<li class="nav-item">
										<a href="?page=laporan-calon" class="nav-link">
											<i class="nav-icon far fa-circle text-info"></i>
											<p>Daftar Kandidat</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="?page=laporan-pemilih" class="nav-link">
											<i class="nav-icon far fa-circle text-info"></i>
											<p>Daftar pemilih</p>
										</a>
									</li>
									<li class="nav-item">
										<a href="?page=laporan-vote" class="nav-link">
											<i class="nav-icon far fa-circle text-info"></i>
											<p>Daftar Voting</p>
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-header">Setting</li>

						<?php
						} elseif ($data_level == "Pemilih") {
						?>
							<li class="nav-item">
								<a href="index.php" class="nav-link">
									<i class="nav-icon far fa fa-edit"></i>
									<p>
										Bilik Suara
									</p>
								</a>
							</li>

							<li class="nav-header">Setting</li>
						<?php
						}
						?>

						<li class="nav-item">
							<a onclick="return confirm('Apakah anda yakin akan keluar ?')" href="logout.php" class="nav-link">
								<i class="nav-icon far fa-circle text-danger"></i>
								<p>
									Logout
								</p>
							</a>
						</li>

				</nav>
				<!-- /.sidebar-menu -->
			</div>
			<!-- /.sidebar -->
		</aside>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
			</section>

			<!-- Main content -->
			<section class="content">
				<!-- /. WEB DINAMIS DISINI ############################################################################### -->
				<div class="container-fluid">

					<?php
					if (isset($_GET['page'])) {
						$hal = $_GET['page'];

						switch ($hal) {
								//Klik Halaman Home Pengguna
							case 'admin':
								include "home/admin.php";
								break;
							case 'pemilih':
								include "home/pemilih.php";
								break;

								//admin
							case 'data-pengguna':
								include "admin/pengguna/data_pengguna.php";
								break;
							case 'add-pengguna':
								include "admin/pengguna/add_pengguna.php";
								break;
							case 'edit-pengguna':
								include "admin/pengguna/edit_pengguna.php";
								break;
							case 'del-pengguna':
								include "admin/pengguna/del_pengguna.php";
								break;

								//calon
							case 'data-calon':
								include "admin/calon/data_calon.php";
								break;
							case 'add-calon':
								include "admin/calon/add_calon.php";
								break;
							case 'edit-calon':
								include "admin/calon/edit_calon.php";
								break;
							case 'del-calon':
								include "admin/calon/del_calon.php";
								break;

								//Pemilih
							case 'data-pemilih':
								include "admin/pemilih/data_pemilih.php";
								break;
							case 'add-pemilih':
								include "admin/pemilih/add_pemilih.php";
								break;
							case 'edit-pemilih':
								include "admin/pemilih/edit_pemilih.php";
								break;
							case 'del-pemilih':
								include "admin/pemilih/del_pemilih.php";
								break;

								//daftar vote
							case 'data-daftarvote':
								include "admin/daftarvote/data_daftarvote.php";
								break;
							case 'add-daftarvote':
								include "admin/daftarvote/add_daftarvote.php";
								break;
							case 'edit-daftarvote':
								include "admin/daftarvote/edit_daftarvote.php";
								break;
							case 'del-daftarvote':
								include "admin/daftarvote/del_daftarvote.php";
								break;
								//detail calon vote dan pemilih vote
							case 'data-daftardetailvote':
								include "admin/daftarvote/data_daftardetailvote.php";
								break;
							case 'action-detailvote':
								include "admin/daftarvote/action_detailvote.php";
								break;

								//Bilik suara
							case 'PsSQAdT':
								include "pemilih/calon/data_calon.php";
								break;
							case 'PsSQBpL':
								include "pemilih/calon/pilih_calon.php";
								break;
							case 'PsSQBBK':
								include "pemilih/calon/buka_calon.php";
								break;
							case 'view':
								include "pemilih/calon/view_calon.php";
								break;

								//Kotak suara
							case 'data-kotak':
								include "admin/kotak/data_kotak.php";
								break;
							case 'view-kotak':
								include "admin/kotak/view_kotak.php";
								break;
							case 'data-suara':
								include "admin/suara/data_suara.php";
								break;
								//Laporan
							case 'laporan-calon':
								include "admin/laporan/laporan_calon.php";
								break;
								//Laporan
							case 'laporan-pemilih':
								include "admin/laporan/laporan_pemilih.php";
								break;
								//Laporan
							case 'laporan-vote':
								include "admin/laporan/laporan_vote.php";
								break;
								//default
							default:
								echo "<center><h1> 404 Page not found!</h1></center>";
								break;
						}
					} else {
						// Auto Halaman Home Pengguna
						if ($data_level == "Administrator") {
							include "home/admin.php";
						} elseif ($data_level == "Pemilih") {
							include "home/pemilih.php";
						}
					}
					?>

				</div>
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<footer class="main-footer">

			Copyright &copy; 2021
			<a target="_blank" href="#">
				<strong>SMK Bina Putra Mandiri</strong>
			</a>


		</footer>

		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-light-gray">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->

	<!-- jQuery -->
	<script src="plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Select2 -->
	<script src="plugins/select2/js/select2.full.min.js"></script>
	<!-- DataTables -->
	<script src="plugins/datatables/jquery.dataTables.js"></script>
	<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
	<!-- AdminLTE App -->
	<script src="dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="dist/js/demo.js"></script>
	<!-- page script -->

	<script src="plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
	<script src="plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
	<script src="plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
	<script src="plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
	<script src="plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
	<script src="plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
	<script src="plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
	<!--	<script src="plugins/js/highcharts/highcharts.js"></script>
	<script src="plugins/js/highcharts/modules/exporting.js"></script>
				-->
	<script src="plugins/highcharts/code/highcharts.js"></script>
	<script src="plugins/highcharts/code/highcharts-3d.js"></script>
	<script src="plugins/highcharts/code/modules/exporting.js"></script>
	<script src="plugins/highcharts/code/modules/export-data.js"></script>
	<script src="plugins/highcharts/code/modules/accessibility.js"></script>


	<script>
		$(function() {

			$("#example1").DataTable();
			$('#example2').DataTable({
				dom: "Bfrtip",
				"paging": false,
				"lengthChange": false,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,
				"buttons": [
					'excelHtml5',
					'pdfHtml5'
				]
			});
			$("#example3").DataTable();
			$("#example4").DataTable();
			$("#example5").DataTable();

			$('#example').DataTable({
				//"dom": 'Bfrtip',
				//"ajax": '?page=view-kotak&id=1',

				"retrieve": true,
				"paging": true,
				"lengthChange": false,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": false,

			});
		});

		$('#data_kotak').DataTable({
			"retrieve": true,
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,

			// "ajax": {
			// 	"url": '?page=view-kotak&id=1',
			// 	"type": "POST"
			// }
		});
	</script>

	<script>
		$(function() {
			//Initialize Select2 Elements
			$('.select2').select2()

			//Initialize Select2 Elements
			$('.select2bs4').select2({
				theme: 'bootstrap4'
			})
		})
	</script>

</body>

</html>