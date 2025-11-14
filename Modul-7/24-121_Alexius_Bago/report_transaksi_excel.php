<?php
$conn = mysqli_connect("localhost","root","","store");
if(!$conn) die("Koneksi gagal: ".mysqli_connect_error());

$awal  = $_GET['awal'];
$akhir = $_GET['akhir'];

$stmt = mysqli_prepare($conn, "
    SELECT DATE(t.waktu_transaksi) AS tanggal,
           SUM(COALESCE(p.total, t.total)) AS total
    FROM transaksi t
    LEFT JOIN pembayaran p ON p.transaksi_id = t.id
    WHERE DATE(t.waktu_transaksi) BETWEEN ? AND ?
    GROUP BY DATE(t.waktu_transaksi)
    ORDER BY tanggal ASC
");
mysqli_stmt_bind_param($stmt, "ss", $awal, $akhir);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$labels = [];
$values = [];
$totalPend = 0;
$count = 0;

while($row = mysqli_fetch_assoc($res)){
    $labels[] = $row['tanggal'];
    $values[] = (float)$row['total'];
    $totalPend += (float)$row['total'];
    $count++;
}

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

echo "
<h4>Rekap Laporan Penjualan (".date('d M Y', strtotime($awal))." sampai ".date('d M Y', strtotime($akhir)).")</h4>

<table border='1' cellpadding='6'>
    <tr style='font-weight:bold; background:#d0d0d0;'>
        <td>No</td>
        <td>Tanggal</td>
        <td>Total</td>
    </tr>";

for($i = 0; $i < count($labels); $i++){
    echo "
    <tr>
        <td>".($i+1)."</td>
        <td>".date('d M Y', strtotime($labels[$i]))."</td>
        <td>Rp".number_format($values[$i], 0, ',', '.')."</td>
    </tr>";
}

echo "
</table>

<br><br>

<table border='1' cellpadding='6'>
    <tr style='font-weight:bold; background:#d0d0d0;'>
        <td>Jumlah Hari</td>
        <td>Total Pendapatan</td>
    </tr>

    <tr>
        <td>{$count} hari</td>
        <td>Rp".number_format($totalPend,0,',','.')."</td>
    </tr>
</table>
";
?>