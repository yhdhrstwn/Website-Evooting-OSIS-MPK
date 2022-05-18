<?php
include_once(dirname(__FILE__) . '/../../inc/koneksi.php');
$action = $_REQUEST['action'];
$kode =  $_REQUEST['kode'];
$id = $_REQUEST['id'];
$window = "";

switch ($action) {
    case 'insertcalon':
        //$id_calon = isset($_GET['id']);
        $sql = "insert tb_votekandidat(daftarvote_id, id_calon, flag_id)
        values(" . $kode . "," . $id . ",1)";
        $teks = "tambah";
        break;
    case 'insertallcalon':
        //$id_calon = isset($_GET['id']);
        $sql = "insert tb_votekandidat(daftarvote_id, id_calon, flag_id)
        select " . $kode . ", id_calon, 1 flag_id from tb_calon where id_calon not in 
        (select id_calon from tb_votekandidat where daftarvote_id=" . $kode . " and flag_id<>9)";
        $teks = "tambah";
        break;
    case 'deletecalon':
        $sql = "update tb_votekandidat set flag_id=9 where daftarvote_id =" . $kode . " and id_calon=" . $id;
        $teks = "hapus";
        $window = "window.location = 'index.php?page=data-daftardetailvote&kode=" . $kode . "'";
        break;
    case 'deleteallcalon':
        $sql = "update tb_votekandidat set flag_id=9 where daftarvote_id = " . $kode;
        $teks = "hapus";
        break;
    case 'insertpemilih':
        $sql = "insert tb_votepemilih(daftarvote_id, id_pemilih, flag_id,status_id)
            values(" . $kode . "," . $id . ",1,1)";
        $teks = "tambah";
        break;
    case 'insertallpemilih':
        $sql = "insert tb_votepemilih(daftarvote_id, id_pemilih, flag_id,status_id)
            select " . $kode . ", id_pengguna, 1, 1 from tb_pengguna where jenis='PST' and status='1' 
            and id_pengguna not in 
            (select id_pemilih from tb_votepemilih where daftarvote_id=" . $kode . " and flag_id<>9)";
        $teks = "tambah";
        break;
    case 'deletepemilih':
        $sql = "update tb_votepemilih set flag_id=9 where daftarvote_id = " . $kode . " and id_pemilih=" . $id;
        $teks = "hapus";
        $window = "window.location = 'index.php?page=data-daftardetailvote&kode=" . $kode . "'";
        break;
    case 'deleteallpemilih':
        $sql = "update tb_votepemilih set flag_id=9 where daftarvote_id = " . $kode;
        $teks = "hapus";
        break;
    case 'setnomorurut': {
            $sql = "select * from tb_votekandidat where flag_id<>9 and daftarvote_id=" . $kode . " order by votekandidat_id";
            $sql1 = mysqli_query($koneksi, $sql);
            $no = 1;
            while ($row = mysqli_fetch_assoc($sql1)) {
                $sql = "update tb_votekandidat set no_urut=" . $no . " where daftarvote_id=" . $kode .
                    " and id_calon=" . $row['id_calon'];
                $query = mysqli_query($koneksi, $sql);
                $no++;
                $teks = "diurutkan";
            }
            break;
        }
}
//echo $sql;
//die;
if ($action != 'setnomorurut') {
    $query = mysqli_query($koneksi, $sql);
}
if ($query) {
    echo "<script>
                Swal.fire({title: 'Data Berhasil $teks',text: '',icon: 'success',confirmButtonText: 'OK'
                }).then((result) => {
                    " . $window . "
                })</script>";
} else {
    echo "<script>
                Swal.fire({title: 'Data Gagal $teks',text: '',icon: 'error',confirmButtonText: 'OK'
                }).then((result) => {
                    " . $window . "
                })</script>";
}
