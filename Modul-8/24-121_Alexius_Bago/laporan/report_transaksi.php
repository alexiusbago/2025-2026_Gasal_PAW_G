<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';
include '../partials/navbar.php';

$start = $_GET['start'] ?? date('Y-m-01');
$end   = $_GET['end'] ?? date('Y-m-t');

$q = mysqli_query($koneksi,
    "SELECT t.*, p.nama,
            DATE(t.waktu_transaksi) AS tgl_saja
     FROM transaksi t
     LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
     WHERE DATE(t.waktu_transaksi) BETWEEN '$start' AND '$end'
     ORDER BY t.id ASC"
);

$qChart = mysqli_query($koneksi,
    "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
     FROM transaksi 
     WHERE DATE(waktu_transaksi) BETWEEN '$start' AND '$end'
     GROUP BY DATE(waktu_transaksi)
     ORDER BY DATE(waktu_transaksi) ASC"
);

$label = [];
$data  = [];

while ($row = mysqli_fetch_assoc($qChart)) {
    $label[] = date('d M Y', strtotime($row['tgl'])); 
    $data[]  = $row['total_harian'];
}
?>

<div class="container mt-4">

    <h3>Laporan Transaksi</h3>

    <form method="GET" class="row g-3 mt-3 mb-4">

        <div class="col-md-3">
            <label>Dari Tanggal</label>
            <input type="date" name="start" value="<?= date('Y-m-d', strtotime($start)) ?>" class="form-control">
        </div>

        <div class="col-md-3">
            <label>Sampai Tanggal</label>
            <input type="date" name="end" value="<?= date('Y-m-d', strtotime($end)) ?>" class="form-control">
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary w-100">Tampilkan</button>
        </div>

        <div class="col-md-3 d-flex align-items-end gap-2">
            <a href="export_excel.php?start=<?= $start ?>&end=<?= $end ?>" class="btn btn-success w-50">Excel</a>

            <button type="button" id="btnPdf" class="btn btn-danger w-50">PDF</button>
        </div>

    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th width="80">ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = mysqli_fetch_assoc($q)): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= date('d M Y', strtotime($row['tgl_saja'])) ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td>Rp <?= number_format($row['total']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <hr class="mt-5">

    <h4>Grafik Penjualan</h4>

    <canvas id="chartPenjualan" height="120"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const ctx = document.getElementById('chartPenjualan').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($label) ?>,
            datasets: [{
                label: "Total Penjualan Harian",
                data: <?= json_encode($data) ?>,
                borderWidth: 1,
                backgroundColor: "rgba(54, 162, 235, 0.7)",
                borderColor: "rgba(54, 162, 235, 1)"
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    document.getElementById('btnPdf').addEventListener('click', function() {
        setTimeout(function() {
            var canvas = document.getElementById('chartPenjualan');
            if (!canvas) {
                alert('Grafik tidak ditemukan.');
                return;
            }
            var imgData = canvas.toDataURL('image/png');

            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'export_pdf.php';
            form.target = '_blank';

            var inputImg = document.createElement('input');
            inputImg.type = 'hidden';
            inputImg.name = 'chart_image';
            inputImg.value = imgData;
            form.appendChild(inputImg);

            var inputStart = document.createElement('input');
            inputStart.type = 'hidden';
            inputStart.name = 'start';
            inputStart.value = '<?= $start ?>';
            form.appendChild(inputStart);

            var inputEnd = document.createElement('input');
            inputEnd.type = 'hidden';
            inputEnd.name = 'end';
            inputEnd.value = '<?= $end ?>';
            form.appendChild(inputEnd);

            document.body.appendChild(form);
            form.submit();
        }, 250);
    });
    </script>
</div>