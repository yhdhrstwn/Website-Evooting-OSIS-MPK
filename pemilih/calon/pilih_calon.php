<?php
$data_id = $_SESSION["ses_id"];

if (isset($_GET['kode'])) {
	$id = $_GET['id'];
	$sql_simpan = "INSERT INTO tb_vote (daftarvote_id, id_calon, id_pemilih, date) VALUES (
			" . $id . ",
            " . $_GET['kode'] . ",
            " . $data_id . ", now());";
	$sql_simpan .= "UPDATE tb_votepemilih set 
			status_id='2'
			WHERE id_pemilih=" . $data_id . " and daftarvote_id=" . $id;
	$query_simpan = mysqli_multi_query($koneksi, $sql_simpan);
	mysqli_close($koneksi);

	if ($query_simpan) {
		echo "<script>
			Swal.fire({title: 'Anda Berhasil Memilih',text: '',icon: 'success',confirmButtonText: 'OK'
			}).then((result) => {if (result.value){
				window.location = 'index.php?page=PsSQAdT';
				}
			})</script>";
	} else {
		echo "<script>
			Swal.fire({title: 'Anda Gagal Memilih',text: '',icon: 'error',confirmButtonText: 'OK'
			}).then((result) => {if (result.value){
				window.location = 'index.php?page=PsSQAdT';
				}
			})</script>";
	}
}
		   //selesai proses simpan data
