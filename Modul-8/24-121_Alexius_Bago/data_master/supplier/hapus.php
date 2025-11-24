<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';

$id = (int) $_GET['id'];

mysqli_query($koneksi, "DELETE FROM supplier WHERE id = $id");

echo "<script>alert('Supplier berhasil dihapus'); window.location='index.php';</script>";
exit;
?>