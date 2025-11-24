<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "store";

$koneksi = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>