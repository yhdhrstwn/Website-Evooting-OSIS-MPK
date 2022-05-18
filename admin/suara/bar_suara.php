<?php
$kode = 1;
if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
}
include dirname(__FILE__) . '/../../inc/koneksi.php';
$sql =

    "select b.nama_calon category, coaleSce(c.jumlah,0) qty from tb_votekandidat a 
left join tb_calon b on a.id_calon=b.id_calon
left join 
(select daftarvote_id, id_calon, count(*) jumlah from tb_vote 
where daftarvote_id=" . $kode . " group by id_calon, daftarvote_id) c
on c.daftarvote_id=a.daftarvote_id and c.id_calon=a.id_calon
where a.daftarvote_id=" . $kode . " and a.flag_id<>9";

// "select nama_calon category, format(qty,0) qty,format(qty,0) jumlah
// from tb_calon a
// join 
// (select b.id_calon, b.daftarvote_id, count(*) qty
//     from tb_vote b 
//     join tb_votekandidat c on b.id_calon=c.id_calon and b.daftarvote_id=c.daftarvote_id
//     where c.daftarvote_id=" . $kode . "  group by b.daftarvote_id, b.id_calon) b
// on a.id_calon=b.id_calon
// where b.daftarvote_id=" . $kode;
//echo $sql;
$result = mysqli_query($koneksi, $sql);
$category = array();
$category['name'] = 'Category';
$rows['name'] = 'Qty';
while ($r = mysqli_fetch_assoc($result)) {
    $category['data'][] = $r['category'];
    $rows['data'][] = $r['qty'];
}
$rslt = array();
array_push($rslt, $category);
array_push($rslt, $rows);
print json_encode($rslt, JSON_NUMERIC_CHECK);
