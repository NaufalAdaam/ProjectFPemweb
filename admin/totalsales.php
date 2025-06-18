<?php
require '../db.php';

try {
    $stmt = $pdo->query("SELECT produk, harga, jumlah, (harga * jumlah) AS total, waktu_pesan
                         FROM pesanan 
                         WHERE status_pesanan = 'Completed' 
                         ORDER BY waktu_pesan DESC");
    $pesanan = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Gagal mengambil data: " . $e->getMessage();
    $pesanan = [];
}

$grandTotal = array_sum(array_column($pesanan, 'total'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Total Sales</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link">Home</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a href="../login.php" class="nav-link">Logout</a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
      <span class="brand-text font-weight-light">TheOrbits Admin</span>
    </a>

    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
         <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Home</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="neworder.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Total Order</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="totalsales.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Total Sales</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="userregistrasion.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User Registration</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><i class="fas fa-cash-register"></i> Total Sales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Total Sales</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header bg-success">
            <h3 class="card-title"><i class="fas fa-table"></i> Penjualan Selesai</h3>
          </div>
          <div class="card-body p-0">
            <?php if (!empty($pesanan)): ?>
              <div class="table-responsive">
                <table class="table table-bordered m-0">
                  <thead class="bg-success text-white">
                    <tr>
                      <th>#</th>
                      <th>Produk</th>
                      <th>Harga Satuan</th>
                      <th>Jumlah</th>
                      <th>Total</th>
                      <th>Waktu</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1; foreach ($pesanan as $row): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['produk']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['waktu_pesan'])) ?></td>
                      </tr>
                    <?php endforeach; ?>
                    <tr class="bg-light">
                      <td colspan="4" class="text-right font-weight-bold">Grand Total</td>
                      <td colspan="2" class="font-weight-bold text-success">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            <?php else: ?>
              <div class="alert alert-info m-3"><i class="fas fa-info-circle"></i> Belum ada penjualan selesai.</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">Version 3.2.0</div>
    <strong>&copy; <?= date('Y') ?> TheOrbits Admin.</strong> All rights reserved.
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
