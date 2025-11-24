<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';

if ($_POST) {

    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telp   = mysqli_real_escape_string($koneksi, $_POST['telp']);

    mysqli_query($koneksi,
        "INSERT INTO supplier (nama, alamat, telp)
         VALUES ('$nama', '$alamat', '$telp')"
    );

    echo "<script>alert('Supplier berhasil ditambahkan'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Tambah Supplier</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Nama Supplier</label>
            <input type="text" name="nama" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="telp" required class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>