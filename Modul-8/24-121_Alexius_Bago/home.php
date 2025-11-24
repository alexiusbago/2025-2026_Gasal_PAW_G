<?php
include 'protect/cek_login.php';
include 'config/koneksi.php';
include 'partials/navbar.php';
?>

<div class="container mt-4">
    <h3>Selamat Datang, <?= $_SESSION['nama_user'] ?></h3>
</div>