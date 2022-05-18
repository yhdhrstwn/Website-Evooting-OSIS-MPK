<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = '(SELECT
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
where a.daftarvote_id=" . $id . ") as data ';

// Table's primary key
$primaryKey = 'id_vote';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array('db' => 'nama_calon', 'dt' => 0),
	array('db' => 'date',  'dt' => 1),
);

// SQL server connection information
$sql_details = array(
	'user' => 'admin',
	'pass' => 'D@n1sh2020',
	'db'   => 'db_vote',
	'host' => 'localhost'
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require('ssp.class.php');

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
