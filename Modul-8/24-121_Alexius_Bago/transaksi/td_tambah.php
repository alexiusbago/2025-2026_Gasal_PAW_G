<?php
include '../protect/cek_login.php';
include '../config/koneksi.php';
include '../partials/navbar.php';

$transaksi = mysqli_query($koneksi, "SELECT id, waktu_transaksi FROM transaksi ORDER BY id ASC");

$barang = mysqli_query($koneksi, "SELECT id, nama_barang, harga FROM barang ORDER BY nama_barang ASC");

if ($_POST) {

    $transaksi_id = (int) $_POST['transaksi_id'];
    $barang_id    = (int) $_POST['barang_id'];
    $harga        = (int) $_POST['harga'];
    $qty          = (int) $_POST['qty'];

    mysqli_query($koneksi,
        "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
         VALUES ($transaksi_id, $barang_id, $harga, $qty)"
    );

    echo "<script>alert('Transaksi detail berhasil ditambahkan'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Tambah Transaksi Detail</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">ID Transaksi</label>
            <select name="transaksi_id" required class="form-control">
                <option value="">-- Pilih Transaksi --</option>
                <?php while ($t = mysqli_fetch_assoc($transaksi)): ?>
                    <option value="<?= $t['id'] ?>">
                        <?= $t['id'] ?> - <?= $t['waktu_transaksi'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Barang</label>
            <select name="barang_id" required class="form-control" onchange="updateHarga(this)">
                <option value="">-- Pilih Barang --</option>
                <?php while ($b = mysqli_fetch_assoc($barang)): ?>
                    <option value="<?= $b['id'] ?>" data-harga="<?= $b['harga'] ?>">
                        <?= htmlspecialchars($b['nama_barang']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" required class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Qty</label>
            <input type="number" name="qty" required class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="transaksi_detail.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>

<script>
function updateHarga(select) {
    const harga = select.options[select.selectedIndex].getAttribute("data-harga");
    document.getElementById("harga").value = harga;
}
</script>