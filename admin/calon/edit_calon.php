<?php

if (isset($_GET['kode'])) {
	$sql_cek = "SELECT * FROM tb_calon WHERE id_calon='" . $_GET['kode'] . "'";
	$query_cek = mysqli_query($koneksi, $sql_cek);
	$data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}
?>

<div class="card card-success">
	<div class="card-header">
		<h3 class="card-title">
			<i class="fa fa-edit"></i> Ubah Data
		</h3>
	</div>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="card-body">

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Nama Calon</label>
				<div class="col-sm-6">
					<input type="text" class="form-control" id="nama_calon" name="nama_calon" value="<?php echo $data_cek['nama_calon']; ?>" />
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Foto Calon</label>
				<div class="col-sm-6">
					<input type="file" id="foto_calon" name="foto_calon">
					<p class="help-block">
						<font color="red">Format image file"</font>
					</p>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Keterangan</label>
				<div class="col-sm-6">
					<textarea class="form-control" rows="5" id="keterangan" name="keterangan" placeholder="Keterangan"><?php echo $data_cek['keterangan']; ?></textarea>
				</div>
			</div>

		</div>
		<div class="card-footer">
			<input type="submit" name="Ubah" value="Simpan" class="btn btn-success">
			<a href="?page=data-calon" title="Kembali" class="btn btn-secondary">Batal</a>
		</div>
	</form>
</div>


<?php

$sumber = @$_FILES['foto_calon']['tmp_name'];
$target = 'foto/';
$nama_file = @$_FILES['foto_calon']['name'];
$pindah = move_uploaded_file($sumber, $target . $nama_file);

if (isset($_POST['Ubah'])) {

	if (!empty($sumber)) {
		$foto = $data_cek['foto_calon'];
		if (file_exists("foto/$foto")) {
			unlink("foto/$foto");
		}

		$sql_ubah = "UPDATE tb_calon SET
            nama_calon='" . $_POST['nama_calon'] . "',
            foto_calon='" . $nama_file . "',
            keterangan='" . $_POST['keterangan'] . "'
            WHERE id_calon=" . $_GET['kode'];
		$query_ubah = mysqli_query($koneksi, $sql_ubah);
	} elseif (empty($sumber)) {
		$sql_ubah = "UPDATE tb_calon SET
            nama_calon='" . $_POST['nama_calon'] . "',
            keterangan='" . $_POST['keterangan'] . "'
            WHERE id_calon=" . $_GET['kode'];
		$query_ubah = mysqli_query($koneksi, $sql_ubah);
	}

	if ($query_ubah) {
		echo "<script>
        Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data-calon';
            }
        })</script>";
	} else {
		echo "<script>
        Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data-calon';
            }
        })</script>";
	}
}
