<?php
$conn = mysqli_connect("localhost","root","","store");
if(!$conn) die("Koneksi gagal: ".mysqli_connect_error());
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Data Master Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { font-family: Arial, Helvetica, sans-serif; }

    .page-box {
      border: 1px solid #d0d7e2;
      border-radius:6px;
      overflow:hidden;
      background:#ffffff;
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

    .page-content {
      padding:20px;
    }

    .actions { 
      display:flex; 
      justify-content:flex-end; 
      gap:8px; 
      margin-bottom:16px; 
    }

    table thead { background:#e9f3ff; }
    .table-sm td, .table-sm th { padding:.45rem; }
  </style>

</head>
<body class="p-4">

<div class="container">

  <div class="page-box">

    <div class="page-header">
      <h4>Data Master Transaksi</h4>
    </div>

    <div class="page-content">

      <div class="actions">
        <a href="report_transaksi.php" class="btn btn-primary">Lihat Laporan Penjualan</a>
        <a href="transaksi_tambah.php" class="btn btn-success">Tambah Transaksi</a>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Transaksi</th>
              <th>Waktu Transaksi</th>
              <th>Nama Pelanggan</th>
              <th>Keterangan</th>
              <th>Total</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no=1;
            $sql = "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama AS pelanggan
                    FROM transaksi t
                    LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
                    ORDER BY t.waktu_transaksi ASC";
            $res = mysqli_query($conn, $sql);
            while($r = mysqli_fetch_assoc($res)) {
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $r['id'] ?></td>
              <td><?= date('d-m-Y H:i', strtotime($r['waktu_transaksi'])) ?></td>
              <td><?= htmlspecialchars($r['pelanggan']) ?></td>
              <td><?= htmlspecialchars($r['keterangan']) ?></td>
              <td>Rp<?= number_format($r['total'],0,',','.') ?></td>
              <td>
                <a href="transaksi_detail.php?id=<?= $r['id'] ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                <a href="transaksi_hapus.php?id=<?= $r['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

    </div>

  </div>

</div>

</body>
</html>