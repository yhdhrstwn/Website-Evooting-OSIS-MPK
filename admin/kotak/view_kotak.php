<?php
//data kolom yang akan di tampilkan
include_once(dirname(__FILE__) . '/../../inc/koneksi.php');

if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
$aColumns = array('nama_pemilih', 'date');
//primary key
$sIndexColumn = "nama_pemilih";

//nama table database
$sTable = "(SELECT
`a`.`id_vote` AS `id_vote`,
`a`.`daftarvote_id` AS `daftarvote_id`,
`a`.`id_calon` AS `id_calon`,
`a`.`id_pemilih` AS `id_pemilih`,
`a`.`date` AS `date`,
`b`.`nama_calon` AS `nama_calon`,
`b`.`foto_calon` AS `foto_calon`,
`b`.`keterangan` AS `keterangan`,
`c`.`nama_pengguna` AS `nama_pemilih` 
FROM
 `tb_vote` `a` JOIN `tb_calon` `b` ON `a`.`id_calon` = `b`.`id_calon` 
JOIN `tb_pengguna` `c` ON `a`.`id_pemilih` = `c`.`id_pengguna` 
where a.daftarvote_id=" . $id . ") as data ";

//echo $sTable;

//informasi koneksi ke database
// $gaSql['user']       = "admin";
// $gaSql['password']   = "D@n1sh2020";
// $gaSql['db']         = "db_vote";
// $gaSql['server']     = "localhost";


//$koneksi =  mysqli_connect($gaSql['server'], $gaSql['user'], $gaSql['password']) or
//die('Could not open connection to server');

// mysqli_select_db($koneksi, $gaSql['db']) or
// 	die('Could not select database ' . $gaSql['db']);


$sLimit = "";
if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
	$sLimit = "LIMIT " . mysqli_real_escape_string($koneksi, $_GET['iDisplayStart']) . ", " .
		mysqli_real_escape_string($koneksi, $_GET['iDisplayLength']);
}

if (isset($_GET['iSortCol_0'])) {
	$sOrder = "ORDER BY  ";
	for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
		if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
			$sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
				 	" . mysqli_real_escape_string($koneksi, $_GET['sSortDir_' . $i]) . ", ";
		}
	}

	$sOrder = substr_replace($sOrder, "", -2);
	if ($sOrder == "ORDER BY") {
		$sOrder = "";
	}
}

$sWhere = "";
if ($_GET['sSearch'] != "") {
	$sWhere = "WHERE (";
	for ($i = 0; $i < count($aColumns); $i++) {
		$sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($koneksi, $_GET['sSearch']) . "%' OR ";
	}
	$sWhere = substr_replace($sWhere, "", -3);
	$sWhere .= ')';
}

for ($i = 0; $i < count($aColumns); $i++) {
	if ($_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
		if ($sWhere == "") {
			$sWhere = "WHERE ";
		} else {
			$sWhere .= " AND ";
		}
		$sWhere .= $aColumns[$i] . " LIKE '%" . mysqli_real_escape_string($koneksi, $_GET['sSearch_' . $i]) . "%' ";
	}
}

$sQuery = "
		SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
		FROM   $sTable
		$sWhere
		$sOrder
		$sLimit
	";
$rResult = mysqli_query($koneksi, $sQuery) or die(mysqli_error($koneksi));

$sQuery = "
		SELECT FOUND_ROWS()
	";
$rResultFilterTotal = mysqli_query($koneksi, $sQuery) or die(mysqli_error($koneksi));
$aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
$iFilteredTotal = $aResultFilterTotal[0];

$sQuery = "
		SELECT COUNT(" . $sIndexColumn . ")
		FROM   $sTable
	";
$rResultTotal = mysqli_query($koneksi, $sQuery) or die(mysqli_error($koneksi));
$aResultTotal = mysqli_fetch_array($rResultTotal);
$iTotal = $aResultTotal[0];



$output = array(
	"sEcho" => intval($_GET['sEcho']),
	"iTotalRecords" => $iTotal,
	"iTotalDisplayRecords" => $iFilteredTotal,
	"aaData" => array()
);

while ($aRow = mysqli_fetch_array($rResult)) {
	$row = array();
	for ($i = 0; $i < count($aColumns); $i++) {
		if ($aColumns[$i] == "version") {
			$row[] = ($aRow[$aColumns[$i]] == "0") ? '-' : $aRow[$aColumns[$i]];
		} else if ($aColumns[$i] != ' ') {
			$row[] = $aRow[$aColumns[$i]];
		}
	}
	$output['aaData'][] = $row;
}

echo json_encode($output);
