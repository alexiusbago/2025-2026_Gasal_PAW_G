<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';

$id = (int) $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id = $id");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Pelanggan tidak ditemukan!");
}

if ($_POST) {

    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jk     = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telp   = mysqli_real_escape_string($koneksi, $_POST['telp']);

    mysqli_query($koneksi,
        "UPDATE pelanggan
         SET nama='$nama',
             jenis_kelamin='$jk',
             alamat='$alamat',
             telp='$telp'
         WHERE id=$id"
    );

    echo "<script>alert('Pelanggan berhasil diupdate'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Edit Pelanggan</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama" class="form-control"
                   value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="L" <?= $data['jenis_kelamin']=='L'?'selected':'' ?>>Laki-laki</option>
                <option value="P" <?= $data['jenis_kelamin']=='P'?'selected':'' ?>>Perempuan</option>
            </select>
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