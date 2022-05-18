<?php
$kode = 1;
if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
}
include dirname(__FILE__) . '/../../inc/koneksi.php';
$sql =
    "select b.nama_calon nama, coaleSce(c.jumlah,0) qty from tb_votekandidat a 
left join tb_calon b on a.id_calon=b.id_calon
left join 
(select daftarvote_id, id_calon, count(*) jumlah from tb_vote 
where daftarvote_id=" . $kode . " group by id_calon, daftarvote_id) c
on c.daftarvote_id=a.daftarvote_id and c.id_calon=a.id_calon
where a.daftarvote_id=" . $kode . " and a.flag_id<>9";

// "select nama_calon nama, format(qty,0) qty,format(qty,0) jumlah
// from tb_calon a
// right join 
// (select b.id_calon, b.daftarvote_id, count(*) qty
//     from tb_vote b 
//     join tb_votekandidat c on b.id_calon=c.id_calon and b.daftarvote_id=c.daftarvote_id
//     where c.daftarvote_id=" . $kode . "  group by b.daftarvote_id, b.id_calon) b
// on a.id_calon=b.id_calon
// where b.daftarvote_id=" . $kode;
//echo $sql;
$rs = mysqli_query($koneksi, $sql);
$rows = array();
while ($r = mysqli_fetch_assoc($rs)) {
    $row[0] = $r['nama'];
    $row[1] = $r['qty'];
    array_push($rows, $row);
}

print json_encode($rows, JSON_NUMERIC_CHECK);
