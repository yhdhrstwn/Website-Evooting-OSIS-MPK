<link rel="stylesheet" type="text/css" href="plugins/css/jquery.datetimepicker.min">
<script src="/plugins/js/jquery.datetimepicker.full.js"></script>
<script src="/plugins/js/jquery.datetimepicker.full.min.js"></script>
<script src="/plugins/js/jquery.datetimepicker.min.js"></script>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-edit"></i> Tambah Data
        </h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="well">
                <div id="datetimepicker2" class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Vote</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama vote" required />
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Keterangan</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan" required />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="tanggal_mulai1" name="tanggal_mulai1" placeholder="Tanggal mulai" required />
                    <input type="time" class="form-control" id="tanggal_mulai2" name="tanggal_mulai2" placeholder="jam mulai" required />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
                <div class="col-sm-6">
                    <input type="date" class="form-control" id="tanggal_selesai1" name="tanggal_selesai1" placeholder="Tanggal selesai" required />
                    <input type="time" class="form-control" id="tanggal_selesai2" name="tanggal_selesai2" placeholder="Jam selesai" required />
                </div>
            </div>

        </div>
        <div class="card-footer">
            <input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
            <a href="?page=data-daftarvote" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php

if (isset($_POST['Simpan'])) {
    date_default_timezone_set("Asia/Bangkok");
    $d = date('Y-m-d', strtotime($_POST['tanggal_mulai1']));
    $d1 = date('H:i:s', strtotime($_POST['tanggal_mulai2']));
    $tglmulai = $d . " " . $d1;
    $d = date('Y-m-d',  strtotime($_POST['tanggal_selesai1']));
    $d1 = date('H:i:s', strtotime($_POST['tanggal_selesai2']));
    $tglselesai = $d . " " . $d1;
    //mulai proses simpan data
    $sql_simpan = "INSERT INTO tb_daftarvote (nama,keterangan,tanggal_mulai,tanggal_selesai,status_id,flag_id) VALUES (
        '" . $_POST['nama'] . "',
        '" . $_POST['keterangan'] . "',
        '" . $tglmulai . "',
        '" . $tglselesai . "',
        '1',1)";

    $query_simpan = mysqli_query($koneksi, $sql_simpan);
    mysqli_close($koneksi);

    if ($query_simpan) {
        echo "<script>
      Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
      }).then((result) => {if (result.value){
          window.location = 'index.php?page=data-daftarvote';
          }
      })</script>";
    } else {
        echo "<script>
      Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
      }).then((result) => {if (result.value){
          window.location = 'index.php?page=add-daftarvote';
          }
      })</script>";
    }
}
//selesai proses simpan data

?>