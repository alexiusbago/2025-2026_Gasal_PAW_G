<?php
include '../../protect/cek_login.php';
include '../../config/koneksi.php';
include '../../partials/navbar.php';

$id = (int) $_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = $id");
$data = mysqli_fetch_assoc($q);

if (!$data) {
    die("User tidak ditemukan");
}

if ($_POST) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    
    $level    = (int) $_POST['level'];

    if ($_POST['password'] != "") {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $pass_sql = "password='$password',";
    } else {
        $pass_sql = "";
    }

    mysqli_query($koneksi,
        "UPDATE user 
         SET nama='$nama',
             $pass_sql
             level='$level'
         WHERE id_user=$id"
    );

    echo "<script>alert('User berhasil diupdate'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 col-md-6">
    <h3>Edit User</h3>

    <form method="POST" class="mt-3">

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Username (tidak bisa diubah)</label>
            <input type="text" value="<?= $data['username'] ?>" class="form-control" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">Password (kosongkan jika tidak diganti)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Level</label>
            <select name="level" class="form-control" required>
                <option value="1" <?= $data['level']==1?'selected':'' ?>>Owner</option>
                <option value="2" <?= $data['level']==2?'selected':'' ?>>Kasir</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>

    </form>
</div>