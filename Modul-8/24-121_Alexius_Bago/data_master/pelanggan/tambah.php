<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';

if ($_POST) {

    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jk     = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $telp   = mysqli_real_escape_string($koneksi, $_POST['telp']);

    mysqli_query($koneksi, 
        "INSERT INTO pelanggan (nama, jenis_kelamin, alamat, telp)
         VALUES ('$nama', '$jk', '$alamat', '$telp')"
    );

    echo "<script>alert('Pelanggan berhasil ditambahkan'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Tambah Pelanggan</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" required class="form-control">
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
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