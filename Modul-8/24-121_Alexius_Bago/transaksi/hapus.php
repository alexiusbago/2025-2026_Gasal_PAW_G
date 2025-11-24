<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';

$id = (int) $_GET['id'];

mysqli_query($koneksi, "DELETE FROM transaksi_detail WHERE transaksi_id = $id");

mysqli_query($koneksi, "DELETE FROM pembayaran WHERE transaksi_id = $id");

mysqli_query($koneksi, "DELETE FROM transaksi WHERE id = $id");

echo "<script>alert('Transaksi berhasil dihapus'); window.location='index.php';</script>";
exit;
?>