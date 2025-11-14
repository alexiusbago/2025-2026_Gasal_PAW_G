<?php
$conn = mysqli_connect("localhost","root","","store");
if(!$conn) die("Koneksi gagal: ".mysqli_connect_error());

$awal  = $_GET['awal'] ?? '';
$akhir = $_GET['akhir'] ?? '';
$show  = ($awal !== '' && $akhir !== '');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laporan Penjualan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body { font-family: Arial, Helvetica, sans-serif; }

    .page-box {
      border: 1px solid #d0d7e2;
      border-radius:6px;
      overflow:hidden;
      background:#ffffff;
      margin-bottom:20px;
    }

    .page-header { 
      background:#0d6efd; 
      color:#fff; 
      padding:14px 18px;
    }

    .page-header h4 {
      margin:0;
      font-size:22px;
      font-weight:600;
    }

    .page-content { padding:20px; }
    .back-box { padding:20px; padding-bottom:10px; }

    .export-box { padding:0px 20px 20px 20px; }

    table thead { background:#e9f3ff; }
  </style>

</head>
<body class="p-4">
<div class="container">

<div class="page-box">

  <?php if(!$show): ?>

    <div class="page-header">
      <h4>Rekap Laporan Penjualan</h4>
    </div>

    <div class="back-box">
      <a href="data_master_transaksi.php" class="btn btn-primary">Kembali</a>
    </div>

    <div class="page-content pt-0">
      <form class="row g-3" method="GET">

        <div class="col-md-4">
          <input type="date" name="awal" class="form-control">
        </div>

        <div class="col-md-4">
          <input type="date" name="akhir" class="form-control">
        </div>

        <div class="col-md-4">
          <button type="submit" class="btn btn-success">Tampilkan</button>
        </div>

      </form>
    </div>

  <?php else: ?>

    <div class="page-header">
      <h4>
        Rekap Laporan Penjualan 
        <?= date('d M Y', strtotime($awal)) ?> 
        sampai 
        <?= date('d M Y', strtotime($akhir)) ?>
      </h4>
    </div>

    <div class="back-box">
      <a href="report_transaksi.php" class="btn btn-primary">Kembali</a>
    </div>

    <div class="export-box">
      <a href="report_transaksi_pdf.php?awal=<?= urlencode($awal) ?>&akhir=<?= urlencode($akhir) ?>" 
         class="btn btn-warning me-2">
         <i class="fa-solid fa-print"></i> Cetak
      </a>

      <a href="report_transaksi_excel.php?awal=<?= urlencode($awal) ?>&akhir=<?= urlencode($akhir) ?>" 
         class="btn btn-warning">
         <i class="fa-solid fa-file-excel"></i> Excel
      </a>
    </div>

    <div class="page-content">

      <?php
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
      ?>

      <div class="mb-3">
        <canvas id="chartPenjualan" height="120"></canvas>
      </div>

      <script>
        new Chart(document.getElementById('chartPenjualan'), {
          type: 'bar',
          data: {
            labels: <?= json_encode(array_map(fn($d)=>date('Y-m-d',strtotime($d)), $labels)) ?>,
            datasets: [{
              label: 'Total',
              data: <?= json_encode($values) ?>,
              backgroundColor: 'rgba(13,110,253,0.8)'
            }]
          },
          options: { 
            scales:{ y:{ beginAtZero:true }, x:{ ticks:{ autoSkip:false }} },
            plugins:{ legend:{ display:false }}
          }
        });
      </script>

      <div class="mb-3">
        <table class="table table-bordered table-sm">
          <thead class="table-primary">
            <tr>
              <th>No</th>
              <th>Total</th>
              <th>Tanggal</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($labels as $i => $tgl): ?>
            <tr>
              <td><?= $i+1 ?></td>
              <td>Rp<?= number_format($values[$i],0,',','.') ?></td>
              <td><?= date('d M Y', strtotime($tgl)) ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="mb-3">
        <table class="table table-bordered table-sm">
          <thead class="table-primary">
            <tr>
              <th>Jumlah Pelanggan</th>
              <th>Jumlah Pendapatan</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= $count ?> orang</td>
              <td>Rp<?= number_format($totalPend,0,',','.') ?></td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>

  <?php endif; ?>

</div>

</div>
</body>
</html>