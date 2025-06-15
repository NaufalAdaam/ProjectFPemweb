<?php
session_start();
require '../db.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // Query dengan JOIN untuk mendapatkan data user dan pesanan
    $stmt = $pdo->prepare("
        SELECT p.*, u.username, u.email 
        FROM pesanan p 
        JOIN users u ON p.user_id = u.id 
        WHERE p.user_id = ? 
        ORDER BY p.waktu_pesan DESC
    ");
    $stmt->execute([$user_id]);
    $pesanan = $stmt->fetchAll();
    
    // Ambil info user yang sedang login
    $stmt_user = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
    $stmt_user->execute([$user_id]);
    $current_user = $stmt_user->fetch();
    
} catch (PDOException $e) {
    echo "Gagal mengambil data: " . $e->getMessage();
    $pesanan = [];
    $current_user = ['username' => 'User', 'email' => ''];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Riwayat Pembelian - <?= htmlspecialchars($current_user['username']) ?></title>
 <!-- Bootstrap dulu -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

<!-- Lalu custom CSS -->
<link rel="stylesheet" href="riwayatpembelian.css">

</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(51, 51, 51)">
    <div class="container">
      <a class="navbar-brand fw-bold text-white" href="#"><s>TheOrbits</s></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="aboutus.php">Tentang Kami</a></li>
          <li class="nav-item"><a class="nav-link" href="produk.php">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="form.php">Form Pemesanan</a></li>
          <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak Kami</a></li>
          <li class="nav-item"><a class="btn btn-outline-light ms-3 active" href="riwayatpembelian.php">Status Pembelian</a></li>
          <li class="nav-item">
            
            <a class="btn btn-danger btn-sm ms-3" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Tabel Riwayat -->
<div class="container table-container mt-4">
  <h2 class="text-center mb-4">Riwayat Pembelian Anda</h2>
  
 

  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Pemesan</th>
          <th>Telepon</th>
          <th>Produk</th>
          <th>Harga Satuan</th>
          <th>Jumlah</th>
          <th>Total Harga</th>
          <th>Alamat</th>
          <th>Waktu Pesan</th>
          <th>Status Pesanan</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($pesanan)): ?>
        <tr>
          <td colspan="10" class="text-center">
            <div class="py-4">
              <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
              <h5 class="text-muted">Belum ada pesanan</h5>
              <p class="text-muted">Silakan lakukan pemesanan terlebih dahulu</p>
              <a href="form.php" class="btn btn-primary">Buat Pesanan</a>
            </div>
          </td>
        </tr>
        <?php else: ?>
          <?php $no = 1; $totalKeseluruhan = 0; ?>
          <?php foreach ($pesanan as $row): ?>
          <?php 
            // Hitung total keseluruhan
            $totalKeseluruhan += isset($row['total']) ? $row['total'] : 0;
          ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['telepon']) ?></td>
            <td><?= htmlspecialchars($row['produk']) ?></td>
            <td>
              <?php if (isset($row['harga']) && $row['harga'] > 0): ?>
                Rp <?= number_format($row['harga'], 0, ',', '.') ?>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['jumlah']) ?></td>
            <td class="fw-bold text-success">
              <?php if (isset($row['total']) && $row['total'] > 0): ?>
                Rp <?= number_format($row['total'], 0, ',', '.') ?>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($row['waktu_pesan'])) ?></td>
            <td>
              <span class="badge 
                <?php 
                  switch(strtolower($row['status_pesanan'])) {
                    case 'pending':
                      echo 'bg-warning text-dark';
                      break;
                    case 'diproses':
                      echo 'bg-info';
                      break;
                    case 'dikirim':
                      echo 'bg-primary';
                      break;
                    case 'selesai':
                    case 'completed':
                      echo 'bg-success';
                      break;
                    case 'dibatalkan':
                      echo 'bg-danger';
                      break;
                    default:
                      echo 'bg-secondary';
                  }
                ?>">
                <?= htmlspecialchars($row['status_pesanan']) ?>
              </span>
            </td>
          </tr>
          <?php endforeach; ?>
          
          <!-- Baris Total Keseluruhan -->
          <?php if ($totalKeseluruhan > 0): ?>
          <tr class="table-info">
            <td colspan="6" class="text-end fw-bold">Total Keseluruhan:</td>
            <td class="fw-bold text-success">
              Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?>
            </td>
            <td colspan="3"></td>
          </tr>
          <?php endif; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Statistik Singkat -->
  <?php if (!empty($pesanan)): ?>
  <div class="row mt-4">
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Total Pesanan</h5>
          <p class="card-text display-6"><?= count($pesanan) ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Total Pembelian</h5>
          <p class="card-text display-6 text-success">
            Rp <?= number_format($totalKeseluruhan, 0, ',', '.') ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Pesanan Pending</h5>
          <p class="card-text display-6 text-warning">
            <?= count(array_filter($pesanan, function($p) { return strtolower($p['status_pesanan']) == 'pending'; })) ?>
          </p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Pesanan Selesai</h5>
          <p class="card-text display-6 text-success">
            <?= count(array_filter($pesanan, function($p) { 
              return in_array(strtolower($p['status_pesanan']), ['completed', 'selesai']); 
            })) ?>
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>