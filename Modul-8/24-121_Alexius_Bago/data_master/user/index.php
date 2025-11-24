<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Data User</h3>
        <a href="tambah.php" class="btn btn-primary">+ Tambah User</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th width="60">ID</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Level</th>
                <th width="160">Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $q = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user ASC");
            while ($row = mysqli_fetch_assoc($q)):
            ?>
            <tr>
                <td><?= $row['id_user'] ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= $row['level'] == 1 ? 'Owner' : 'Kasir' ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_user'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="hapus.php?id=<?= $row['id_user'] ?>" 
                       class="btn btn-sm btn-danger"
                       onclick="return confirm('Hapus user ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>