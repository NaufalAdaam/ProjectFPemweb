<?php
require '../db.php';

// Ambil data pesanan dari database
$stmt = $pdo->query("SELECT * FROM pesanan ORDER BY waktu_pesan DESC");
$pesanan = $stmt->fetchAll();

// Fungsi untuk menentukan warna badge - disesuaikan dengan enum database
function getBadgeClass($status) {
    switch ($status) {
        case 'Pending': return 'badge-warning';
        case 'Proces': return 'badge-primary';
        case 'Delivered': return 'badge-success';
        case 'Completed': return 'badge-info';
        default: return 'badge-secondary';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>New Orders</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="hold-transition layout-top-nav">
  <div class="wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container mt-4">
        <h2 class="mb-3"><i class="fas fa-shopping-basket"></i> New Orders</h2>

        <div class="card">
          <div class="card-header bg-info text-white">
            <h3 class="card-title"><i class="fas fa-list-ul"></i> Recent Orders</h3>
          </div>
          <div class="card-body">
            <?php if (!empty($pesanan)): ?>
            <ul class="list-group">
              <?php foreach ($pesanan as $order): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                  <strong>Order ID:</strong> <?= 'ORD' . str_pad($order['id'], 4, '0', STR_PAD_LEFT) ?><br>
                  <small><strong>Item:</strong> <?= htmlspecialchars($order['produk']) ?></small><br>
                  <small><strong>Nama:</strong> <?= htmlspecialchars($order['nama']) ?></small><br>
                  <small><strong>Jumlah:</strong> <?= $order['jumlah'] ?></small><br>
                  <small><strong>Telepon:</strong> <?= htmlspecialchars($order['telepon']) ?></small><br>
                  <small><strong>Alamat:</strong> <?= htmlspecialchars($order['alamat']) ?></small><br>
                  <small><strong>Waktu Pesan:</strong> <?= date('d/m/Y H:i', strtotime($order['waktu_pesan'])) ?></small>
                </div>
                <div class="d-flex flex-column align-items-end">
                  <form method="post" action="update-status.php" class="form-inline d-flex align-items-center mb-2">
                    <input type="hidden" name="id" value="<?= $order['id'] ?>">
                    <select name="status" class="form-control form-control-sm mr-2">
                      <option value="Pending" <?= $order['status_pesanan'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                      <option value="Proces" <?= $order['status_pesanan'] == 'Proces' ? 'selected' : '' ?>>Processing</option>
                      <option value="Delivered" <?= $order['status_pesanan'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                      <option value="Completed" <?= $order['status_pesanan'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                  </form>
                  <span class="badge <?= getBadgeClass($order['status_pesanan']) ?>"><?= htmlspecialchars($order['status_pesanan']) ?></span>
                </div>
              </li>
              <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <div class="alert alert-info text-center">
              <i class="fas fa-info-circle"></i> Tidak ada pesanan yang ditemukan.
            </div>
            <?php endif; ?>
          </div>
        </div>

        <a href="index.php" class="btn btn-secondary mt-3">
          <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
      </div>
    </section>

  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>