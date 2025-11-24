<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';

$id = (int) $_GET['id'];

mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id = $id");

echo "<script>alert('Pelanggan berhasil dihapus'); window.location='index.php';</script>";
exit;
?>