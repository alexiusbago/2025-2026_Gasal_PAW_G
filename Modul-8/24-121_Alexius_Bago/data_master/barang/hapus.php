<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';

$id = (int) $_GET['id'];

mysqli_query($koneksi, "DELETE FROM transaksi_detail WHERE barang_id = $id");

mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");

echo "<script>alert('Barang berhasil dihapus'); window.location='index.php';</script>";
exit;
?>