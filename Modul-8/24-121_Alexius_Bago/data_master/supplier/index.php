<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data Supplier</h3>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Supplier</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th width="70">ID</th>
                <th>Nama Supplier</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $q = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id ASC");
            while ($row = mysqli_fetch_assoc($q)):
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['telp']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus supplier ini?')" class="btn btn-sm btn-danger">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

</div>