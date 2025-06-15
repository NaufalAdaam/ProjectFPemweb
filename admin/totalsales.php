<?php
require '../db.php'; // sesuaikan path jika file ini berada di subfolder

try {
    $stmt = $pdo->query("SELECT produk, harga, jumlah, (harga * jumlah) AS total 
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Total Sales Detail</title>
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper" style="margin-left: 0;">
    <section class="content">
      <div class="container-fluid mt-4">
        <h2>Total Sales Detail</h2>
        <div class="card mt-3">
          <div class="card-header bg-success text-white">
            <h3 class="card-title">Sales Summary</h3>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>Unit Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($pesanan)): ?>
                  <tr>
                    <td colspan="5" class="text-center">Belum ada data penjualan</td>
                  </tr>
                <?php else: ?>
                  <?php $no = 1; ?>
                  <?php foreach ($pesanan as $row): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= htmlspecialchars($row['produk']) ?></td>
                      <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                      <td><?= $row['jumlah'] ?></td>
                      <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <tr class="bg-light">
                    <td colspan="4" class="text-right font-weight-bold">Grand Total:</td>
                    <td class="font-weight-bold text-success">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
      </div>
    </section>
  </div>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
