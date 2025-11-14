<?php
require_once "dompdf/autoload.inc.php";
use Dompdf\Dompdf;
use Dompdf\Options;

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

$chartConfig = [
    "type" => "bar",
    "data" => [
        "labels" => array_map(fn($d)=>date("d M", strtotime($d)), $labels),
        "datasets" => [[
            "label" => "Total",
            "backgroundColor" => "rgba(13,110,253,0.8)",
            "data" => $values
        ]]
    ]
];

$chartURL = "https://quickchart.io/chart?width=800&height=400&format=png&c=" 
            . urlencode(json_encode($chartConfig));

$chartData = file_get_contents($chartURL);
$chartBase64 = base64_encode($chartData);
$chartIMG = "data:image/png;base64,".$chartBase64;

$html = '
<style>
body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.table th { border: 1px solid #333; padding: 6px; background:#e9f3ff; }
.table td { border: 1px solid #333; padding: 6px; }
.title { font-size: 18px; font-weight: bold; margin-bottom: 10px; background:#0d6efd; color:#fff; padding:14px 18px;}
</style>

<h4 class="title">Rekap Laporan Penjualan '.date("d M Y", strtotime($awal)).' sampai '.date("d M Y", strtotime($akhir)).'</h4>

<img src="'.$chartIMG.'" style="width:100%; margin-bottom:20px;" />

<table class="table">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>';

foreach($labels as $i => $tgl){
    $html .= '
    <tr>
      <td>'.($i+1).'</td>
      <td>'.date("d M Y", strtotime($tgl)).'</td>
      <td>Rp'.number_format($values[$i],0,",",".").'</td>
    </tr>';
}

$html .= '
  </tbody>
</table>

<table class="table">
  <tr>
    <th>Jumlah Hari</th>
    <th>Total Pendapatan</th>
  </tr>
  <tr>
    <td>'.$count.' hari</td>
    <td>Rp'.number_format($totalPend,0,",",".").'</td>
  </tr>
</table>
';

$options = new Options();
$options->set('isRemoteEnabled', true);

$pdf = new Dompdf($options);

$pdf->loadHtml($html);
$pdf->setPaper('A4', 'portrait');
$pdf->render();

$pdf->stream("laporan_penjualan.pdf", ["Attachment" => true]);
?>