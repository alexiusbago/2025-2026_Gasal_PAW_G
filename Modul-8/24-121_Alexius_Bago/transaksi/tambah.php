<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';
include '../partials/navbar.php';

$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY nama ASC");

if ($_POST) {

    $waktu  = mysqli_real_escape_string($koneksi, $_POST['waktu_transaksi']);
    $ket    = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $total  = (int) $_POST['total'];
    $pel_id = (int) $_POST['pelanggan_id'];

    mysqli_query($koneksi,
        "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id)
         VALUES ('$waktu', '$ket', '$total', '$pel_id')"
    );

    echo "<script>alert('Transaksi berhasil ditambahkan'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Tambah Transaksi</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Waktu Transaksi</label>
            <input type="datetime-local" name="waktu_transaksi" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" required class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="number" name="total" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Pelanggan</label>
            <select name="pelanggan_id" required class="form-control">
                <option value="">-- Pilih Pelanggan --</option>
                <?php while ($p = mysqli_fetch_assoc($pelanggan)): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>