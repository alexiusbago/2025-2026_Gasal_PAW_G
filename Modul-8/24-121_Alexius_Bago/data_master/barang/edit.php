<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';

$id = (int) $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM barang WHERE id = $id");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Barang tidak ditemukan!");
}

if ($_POST) {

    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];

    mysqli_query($koneksi,
        "UPDATE barang
         SET nama_barang='$nama',
             harga='$harga',
             stok='$stok'
         WHERE id=$id"
    );

    echo "<script>alert('Barang berhasil diupdate'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Edit Barang</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control"
                   value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control"
                   value="<?= $data['harga'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control"
                   value="<?= $data['stok'] ?>" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>