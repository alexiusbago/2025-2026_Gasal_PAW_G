<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';

$id = (int) $_GET['id'];

mysqli_query($koneksi, "DELETE FROM user WHERE id_user = $id");

echo "<script>alert('User berhasil dihapus'); window.location='index.php';</script>";
exit;
?>