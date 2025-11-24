<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';
include '../partials/navbar.php';

$transaksi_id = (int) $_GET['transaksi_id'];
$barang_id    = (int) $_GET['barang_id'];

$q = mysqli_query($koneksi,
    "SELECT td.*, b.nama_barang 
     FROM transaksi_detail td
     LEFT JOIN barang b ON b.id = td.barang_id
     WHERE td.transaksi_id = $transaksi_id
       AND td.barang_id = $barang_id"
);

$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("Data transaksi detail tidak ditemukan!");
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang ASC");

if ($_POST) {

    $new_barang_id = (int) $_POST['barang_id'];
    $harga         = (int) $_POST['harga'];
    $qty           = (int) $_POST['qty'];

    mysqli_query($koneksi,
        "UPDATE transaksi_detail SET
            barang_id = $new_barang_id,
            harga = $harga,
            qty = $qty
         WHERE transaksi_id = $transaksi_id
           AND barang_id = $barang_id"
    );

    echo "<script>alert('Transaksi detail berhasil diupdate'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Edit Transaksi Detail</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">ID Transaksi</label>
            <input type="text" class="form-control" value="<?= $transaksi_id ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Barang</label>
            <select name="barang_id" class="form-control" required>
                <?php while ($b = mysqli_fetch_assoc($barang)): ?>
                    <option value="<?= $b['id'] ?>"
                        <?= $b['id'] == $data['barang_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($b['nama_barang']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control"
                   value="<?= $data['harga'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Qty</label>
            <input type="number" name="qty" class="form-control"
                   value="<?= $data['qty'] ?>" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="transaksi_detail.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>