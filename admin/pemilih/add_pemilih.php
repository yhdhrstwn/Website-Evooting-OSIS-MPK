<?php
//membuat password acak
function SetPassword()
{
    $pass = '';
    $chars = '0123456789ABCDEFGH';
    for ($i = 0; $i < 5; $i++) {
        $pos = rand(0, strlen($chars) - 1);
        $pass .= $chars[$pos];
    }
    return $pass;
}
?>

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-edit"></i> Tambah Data
        </h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Pemilih</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" placeholder="Nama user" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                </div>
            </div>

        </div>
        <div class="card-footer">
            <input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
            <a href="?page=MyApp/data_pengguna" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php

if (isset($_POST['Simpan'])) {
    //cek username
    $query = "select * from tb_pengguna where username='" . $_POST['username'] . "'";
    $row = mysqli_query($koneksi, $query);
    $jumlah = mysqli_num_rows($row);
    if ($jumlah > 0) {
        $err = 'Data Sudah ada!';
    }
    //mulai proses simpan data
    $sql_simpan = "INSERT INTO tb_pengguna (nama_pengguna,username,password,level,status,jenis) VALUES (
        '" . $_POST['nama_pengguna'] . "',
        '" . $_POST['username'] . "',
        '" . SetPassword() . "',
        'Pemilih',
        '1',
        'PST')";
    $query_simpan = mysqli_query($koneksi, $sql_simpan);

    if ($query_simpan) {
        echo "<script>
      Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
      }).then((result) => {if (result.value){
          window.location = 'index.php?page=data-pemilih';
          }
      })</script>";
    } else {
        //$err =  mysqli_error($koneksi);
        //$errstr = 'Tambah Data Gagal' . $err;
        echo "<script>
      Swal.fire({title: 'Tambah Data Gagal " . $err . "',text: '',icon: 'error',confirmButtonText: 'OK'
      }).then((result) => {if (result.value){
          window.location = 'index.php?page=add-pemilih';
          }
      })</script>";
    }
    mysqli_close($koneksi);
}
     //selesai proses simpan data
