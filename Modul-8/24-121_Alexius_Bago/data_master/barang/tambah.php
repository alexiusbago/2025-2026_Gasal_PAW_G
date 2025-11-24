<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';

if ($_POST) {

    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];

    mysqli_query($koneksi, 
        "INSERT INTO barang (nama_barang, harga, stok)
         VALUES ('$nama', '$harga', '$stok')"
    );

    echo "<script>alert('Barang berhasil ditambahkan'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Tambah Barang</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Nama Barang</label>
            <input type="text" name="nama_barang" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" required class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>