<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';
include '../partials/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Transaksi Detail</h3>

        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-info">Kembali</a>
            <a href="td_tambah.php" class="btn btn-primary">+ Tambah Transaksi Detail</a>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID Transaksi</th>
                <th>Barang</th>
                <th>Qty</th>
                <th>Harga</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $q = mysqli_query($koneksi,
                "SELECT 
                    td.transaksi_id,
                    td.barang_id,
                    b.nama_barang,
                    td.qty,
                    td.harga
                 FROM transaksi_detail td
                 LEFT JOIN barang b ON b.id = td.barang_id
                 ORDER BY td.transaksi_id ASC"
            );

            while ($row = mysqli_fetch_assoc($q)):
            ?>
            <tr>
                <td><?= $row['transaksi_id'] ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= $row['qty'] ?></td>
                <td><?= number_format($row['harga'],0,',','.') ?></td>

                <td>
                    <a 
                        href="td_edit.php?transaksi_id=<?= $row['transaksi_id'] ?>&barang_id=<?= $row['barang_id'] ?>"
                        class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <a 
                        href="td_hapus.php?transaksi_id=<?= $row['transaksi_id'] ?>&barang_id=<?= $row['barang_id'] ?>"
                        onclick="return confirm('Hapus data ini?')"
                        class="btn btn-sm btn-danger">
                        Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

</div>