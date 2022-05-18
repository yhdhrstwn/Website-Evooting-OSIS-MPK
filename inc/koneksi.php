<?php
$HOST = "localhost";
$USERNAME = "root";
$PASSWORD = "";
$DATABASE = "db_vote";
$koneksi = new mysqli($HOST, $USERNAME, $PASSWORD, $DATABASE);

// Check connection
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}
