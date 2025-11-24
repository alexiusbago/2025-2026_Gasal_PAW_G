<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';

$start = $_GET['start'] ?? date('Y-m-01');
$end   = $_GET['end'] ?? date('Y-m-t');

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_transaksi_{$start}_{$end}.xls");
header("Cache-Control: max-age=0");

$sql = "SELECT t.*, p.nama,
            DATE(t.waktu_transaksi) AS tgl_saja
     FROM transaksi t
     LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
     WHERE DATE(t.waktu_transaksi) BETWEEN '$start' AND '$end'
     ORDER BY t.id ASC";

$res = mysqli_query($koneksi, $sql);

echo "<h2>Laporan Transaksi</h2>";
echo "<p>Periode: " . date('d M Y', strtotime($start)) . " s.d. " . date('d M Y', strtotime($end)) . "</p>";

echo "<table border='1'>";
echo "<tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Total Harga</th></tr>";

$totalAll = 0;
while ($row = mysqli_fetch_assoc($res)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . date('d M Y', strtotime($row['tgl_saja'])) . "</td>";
    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
    echo "<td style='mso-number-format:\"\\Rp #,##0\";'>" . $row['total'] . "</td>";
    echo "</tr>";
    $totalAll += (float)$row['total'];
}

echo "<tr><td colspan='3' style='text-align:right;'><strong>Total</strong></td><td><strong>Rp " . number_format($totalAll) . "</strong></td></tr>";
echo "</table>";
exit;