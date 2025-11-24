<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';

$transaksi_id = (int) $_GET['transaksi_id'];
$barang_id    = (int) $_GET['barang_id'];

if ($transaksi_id <= 0 || $barang_id <= 0) {
    die("ID tidak valid");
}

mysqli_query($koneksi, 
    "DELETE FROM transaksi_detail 
     WHERE transaksi_id = $transaksi_id 
       AND barang_id = $barang_id"
);

echo "<script>alert('Transaksi detail berhasil dihapus'); window.location='index.php';</script>";
exit;
?>