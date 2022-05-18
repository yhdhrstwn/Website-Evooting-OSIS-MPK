<?php

if (isset($_GET['kode'])) {
    $sql_cek = "SELECT * FROM tb_daftarvote WHERE daftarvote_id='" . $_GET['kode'] . "'";
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

            <input type='hidden' class="form-control" name="daftarvote_id" id="daftarvote_id" value="<?php echo $data_cek['daftarvote_id']; ?>" readonly />

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Vote</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data_cek['nama']; ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $data_cek['keterangan']; ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="tanggal_mulai1" name="tanggal_mulai1" value="<?php echo date('Y-m-d', strtotime($data_cek['tanggal_mulai'])); ?>" />
                    <input type="time" class="form-control" id="tanggal_mulai2" name="tanggal_mulai2" value="<?php echo date('H:i:s', strtotime($data_cek['tanggal_mulai'])); ?>" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="tanggal_selesai1" name="tanggal_selesai1" value="<?php echo date('Y-m-d', strtotime($data_cek['tanggal_selesai'])); ?>" />
                    <input type="time" class="form-control" id="tanggal_selesai2" name="tanggal_selesai2" value="<?php echo date('H:s:i', strtotime($data_cek['tanggal_selesai'])); ?>" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-4">
                    <select name="status_id" id="status_id" class="form-control">
                        <option>- Pilih -</option>
                        <option value="0" <?php echo ($data_cek['status_id'] == '0') ? 'selected' : '' ?>>Inaktif</option>
                        <option value="1" <?php echo ($data_cek['status_id'] == '1') ? 'selected' : '' ?>>Aktif</option>
                        <option value="2" <?php echo ($data_cek['status_id'] == '2') ? 'selected' : '' ?>>Tutup</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <input type="submit" name="Ubah" value="Simpan" class="btn btn-success">
            <a href="?page=data-daftarvote" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>



<?php

if (isset($_POST['Ubah'])) {
    date_default_timezone_set("Asia/Bangkok");
    $d = date('Y-m-d', strtotime($_POST['tanggal_mulai1']));
    $d1 = date('H:i:s', strtotime($_POST['tanggal_mulai2']));
    $tglmulai = $d . " " . $d1;
    $d = date('Y-m-d',  strtotime($_POST['tanggal_selesai1']));
    $d1 = date('H:i:s', strtotime($_POST['tanggal_selesai2']));
    $tglselesai = $d . " " . $d1;
    $sql_ubah = "UPDATE tb_daftarvote SET nama='" . $_POST['nama'] . "',
        keterangan='" . $_POST['keterangan'] . "',
        tanggal_mulai='" .  $tglmulai . "',
        tanggal_selesai='" .  $tglselesai . "',
        status_id='" . $_POST['status_id'] . "'
        WHERE daftarvote_id=" . $_POST['daftarvote_id'];

    $query_ubah1 = mysqli_query($koneksi, $sql_ubah);
    mysqli_close($koneksi);
    if ($query_ubah1) {
        echo "<script>
      Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
      }).then((result) => {if (result.value)
        {window.location = 'index.php?page=data-daftarvote';
        }
      })</script>";
    } else {
        echo "<script>
      Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
      }).then((result) => {if (result.value)
        {window.location = 'index.php?page=data-daftarvote';
        }
      })</script>";
    }
}
?>