<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';

$id = (int) $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id = $id");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Supplier tidak ditemukan!");
}

if ($_POST) {

    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telp   = mysqli_real_escape_string($koneksi, $_POST['telp']);

    mysqli_query($koneksi,
        "UPDATE supplier SET
            nama='$nama',
            alamat='$alamat',
            telp='$telp'
         WHERE id=$id"
    );

    echo "<script>alert('Supplier berhasil diupdate'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Edit Supplier</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Nama Supplier</label>
            <input type="text" name="nama" class="form-control"
                   value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="telp" class="form-control"
                   value="<?= htmlspecialchars($data['telp']) ?>" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>