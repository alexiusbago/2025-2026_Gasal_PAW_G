<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';

require_once __DIR__ . '/../dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true);

$start = $_POST['start'] ?? $_GET['start'] ?? date('Y-m-01');
$end   = $_POST['end'] ?? $_GET['end'] ?? date('Y-m-t');

$chart_image = $_POST['chart_image'] ?? '';

$sql = "SELECT t.*, p.nama,
            DATE(t.waktu_transaksi) AS tgl_saja
     FROM transaksi t
     LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
     WHERE DATE(t.waktu_transaksi) BETWEEN '$start' AND '$end'
     ORDER BY t.id ASC";

$res = mysqli_query($koneksi, $sql);

$html = '<div style="font-family: sans-serif;">';
$html .= '<h2 style="text-align:center;">Laporan Transaksi</h2>';
$html .= '<p style="text-align:center;">Periode: ' . date('d M Y', strtotime($start)) . ' s.d. ' . date('d M Y', strtotime($end)) . '</p>';

$html .= '<h3>Grafik Penjualan</h3>';

if ($chart_image !== '') {
    $html .= "<div style='text-align:center; margin-bottom:10px;'>
                <img src=\"$chart_image\" style='max-width:700px; width:100%; height:auto;'>
              </div>";
} else {
    $html .= "<p><i>Grafik tidak tersedia.</i></p>";
}

$html .= '<h3>Data Transaksi</h3>';
$html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%">';
$html .= '<thead><tr style="background:#eee">
            <th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Total Harga</th>
          </tr></thead><tbody>';

$totalAll = 0;
while ($row = mysqli_fetch_assoc($res)) {
    $html .= '<tr>
        <td>' . $row['id'] . '</td>
        <td>' . date('d M Y', strtotime($row['tgl_saja'])) . '</td>
        <td>' . htmlspecialchars($row['nama']) . '</td>
        <td>Rp ' . number_format($row['total']) . '</td>
    </tr>';
    $totalAll += (float)$row['total'];
}

$html .= '</tbody>';
$html .= "<tr><td colspan='3' style='text-align:right;'><strong>Total</strong></td>
          <td><strong>Rp " . number_format($totalAll) . '</strong></td></tr>';
$html .= '</table></div>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_transaksi_{$start}_{$end}.pdf", ["Attachment" => true]);
exit;
?>