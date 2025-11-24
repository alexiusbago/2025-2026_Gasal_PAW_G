<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';
include '../partials/navbar.php';

$id = (int) $_GET['id'];

$q = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id = $id");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Transaksi tidak ditemukan!");
}

$pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY nama ASC");

if ($_POST) {

    $waktu  = mysqli_real_escape_string($koneksi, $_POST['waktu_transaksi']);
    $ket    = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $total  = (int) $_POST['total'];
    $pel_id = (int) $_POST['pelanggan_id'];

    mysqli_query($koneksi,
        "UPDATE transaksi SET 
            waktu_transaksi = '$waktu',
            keterangan = '$ket',
            total = '$total',
            pelanggan_id = '$pel_id'
         WHERE id = $id"
    );

    echo "<script>alert('Transaksi berhasil diupdate'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Edit Transaksi</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Waktu Transaksi</label>
            <input type="datetime-local" name="waktu_transaksi" class="form-control"
                   value="<?= date('Y-m-d\TH:i', strtotime($data['waktu_transaksi'])) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" required><?= htmlspecialchars($data['keterangan']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="number" name="total" class="form-control"
                   value="<?= $data['total'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Pelanggan</label>
            <select name="pelanggan_id" class="form-control" required>
                <option value="">-- Pilih Pelanggan --</option>

                <?php while ($p = mysqli_fetch_assoc($pelanggan)): ?>
                    <option value="<?= $p['id'] ?>"
                        <?= $p['id'] == $data['pelanggan_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nama']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>