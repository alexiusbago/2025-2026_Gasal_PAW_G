<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';
include '../partials/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Transaksi</h3>

        <div class="d-flex gap-2">
            <a href="transaksi_detail.php" class="btn btn-info">Lihat Transaksi Detail</a>
            <a href="tambah.php" class="btn btn-primary">+ Tambah Transaksi</a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th width="70">ID</th>
                <th>Waktu Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Keterangan</th>
                <th>Total</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $q = mysqli_query($koneksi,
                "SELECT t.*, p.nama AS nama_pelanggan
                 FROM transaksi t
                 LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
                 ORDER BY t.id ASC"
            );

            while ($row = mysqli_fetch_assoc($q)):
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['waktu_transaksi'] ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td><?= number_format($row['total'],0,',','.') ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus transaksi ini?')" class="btn btn-sm btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

</div>