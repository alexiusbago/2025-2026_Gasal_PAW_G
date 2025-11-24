<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Penjualan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">

    <a class="navbar-brand" href="/TP8/home.php">Sistem Penjualan</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navmenu">

      <ul class="navbar-nav me-auto">

        <li class="nav-item"><a class="nav-link" href="/TP8/home.php">Home</a></li>

        <?php if ($_SESSION['level'] == 1): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Data Master</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/TP8/data_master/barang/">Data Barang</a></li>
                <li><a class="dropdown-item" href="/TP8/data_master/supplier/">Data Supplier</a></li>
                <li><a class="dropdown-item" href="/TP8/data_master/pelanggan/">Data Pelanggan</a></li>
                <li><a class="dropdown-item" href="/TP8/data_master/user/">Data User</a></li>
            </ul>
        </li>
        <?php endif; ?>

        <li class="nav-item"><a class="nav-link" href="/TP8/transaksi/">Transaksi</a></li>
        <li class="nav-item"><a class="nav-link" href="/TP8/laporan/report_transaksi.php">Laporan</a></li>

      </ul>

      <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                  <?= $_SESSION['nama_user'] ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                  <li><a class="dropdown-item" href="/TP8/auth/logout.php">Logout</a></li>
              </ul>
          </li>
      </ul>

    </div>

  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>