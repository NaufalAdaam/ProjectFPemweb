<?php
session_start(); // Tambahkan ini
require '../db.php';

// Periksa apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session
    $nama = $_POST['nama'] ?? '';
    $telepon = $_POST['telepon'] ?? '';
    $produk = $_POST['produk'] ?? '';
    $jumlah = $_POST['jumlah'] ?? 1;
    $alamat = $_POST['alamat'] ?? '';
    $harga = $_POST['harga'] ?? 0;

    try {
        // Update query untuk include user_id
        $stmt = $pdo->prepare("INSERT INTO pesanan (user_id, nama, telepon, produk, jumlah, alamat, harga, status_pesanan)
                               VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $nama, $telepon, $produk, $jumlah, $alamat, $harga]);

        echo "<script>
            alert('Pesanan berhasil disimpan!');
            window.location.href = 'riwayatpembelian.php';
        </script>";
        exit;
    } catch (PDOException $e) {
        echo "<script>alert('Gagal menyimpan data: " . addslashes($e->getMessage()) . "');</script>";
    }
}

// Ambil info user untuk ditampilkan
$current_user = $_SESSION['username'] ?? 'User';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pemesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="form.css">
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
          <li class="nav-item"><a class="nav-link active" href="form.php">Form Pemesanan</a></li>
          <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak Kami</a></li>
          <li class="nav-item"><a class="btn btn-outline-light ms-3 active" href="riwayatpembelian.php">Status Pembelian</a></li>
          <li class="nav-item">
           
            <a class="btn btn-danger btn-sm ms-3" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<!-- Form Section -->
<section class="container my-5 form-container">
  <h2 class="text-center mb-4">Form Pemesanan</h2>
  

  <form id="formPemesanan" method="POST" action="form.php">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Lengkap</label>
      <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required />
      <small class="form-text text-muted">Nama penerima barang</small>
    </div>
    <div class="mb-3">
      <label for="telepon" class="form-label">Nomor Telepon</label>
      <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="08xxxxxxxxxx" required />
    </div>
    <div class="mb-3">
      <label for="produk" class="form-label">Pilih Produk</label>
      <select class="form-select" id="produk" name="produk" onchange="updateHarga()" required>
        <option value="">-- Pilih Produk --</option>
        <option value="Orbital Path" data-harga="160000">Orbital Path - Rp 160.000</option>
        <option value="The Nature Of The Black Hole" data-harga="90000">The Nature Of The Black Hole - Rp 90.000</option>
      </select>
    </div>
    <div class="mb-3">
      <label for="harga" class="form-label">Harga Satuan</label>
      <input type="text" class="form-control" id="hargaDisplay" placeholder="Pilih produk terlebih dahulu" readonly />
      <input type="hidden" id="harga" name="harga" value="0" />
    </div>
    <div class="mb-3">
      <label for="jumlah" class="form-label">Jumlah</label>
      <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" value="1" onchange="updateTotal()" required />
    </div>
    <div class="mb-3">
      <label for="total" class="form-label">Total Harga</label>
      <input type="text" class="form-control" id="totalDisplay" placeholder="Rp 0" readonly />
      <div class="form-text">Total akan dihitung otomatis dari harga × jumlah</div>
    </div>
    <div class="mb-3">
      <label for="alamat" class="form-label">Alamat Pengiriman</label>
      <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap untuk pengiriman" required></textarea>
    </div>
    <div class="d-grid gap-2">
      <button type="submit" class="btn btn-primary btn-lg">
        <i class="fas fa-shopping-cart"></i> Kirim Pesanan
      </button>
      <a href="riwayatpembelian.php" class="btn btn-outline-secondary">
        <i class="fas fa-history"></i> Lihat Riwayat Pesanan
      </a>
    </div>
  </form>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function updateHarga() {
    const produkSelect = document.getElementById('produk');
    const hargaInput = document.getElementById('harga');
    const hargaDisplay = document.getElementById('hargaDisplay');
    
    const selectedOption = produkSelect.options[produkSelect.selectedIndex];
    
    if (selectedOption.value) {
        const harga = selectedOption.getAttribute('data-harga');
        hargaInput.value = harga;
        hargaDisplay.value = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
        updateTotal();
    } else {
        hargaInput.value = '0';
        hargaDisplay.value = '';
        updateTotal();
    }
}

function updateTotal() {
    const harga = parseInt(document.getElementById('harga').value) || 0;
    const jumlah = parseInt(document.getElementById('jumlah').value) || 0;
    const total = harga * jumlah;
    
    document.getElementById('totalDisplay').value = 'Rp ' + total.toLocaleString('id-ID');
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateTotal();
});

// Form validation
document.getElementById('formPemesanan').addEventListener('submit', function(e) {
    const produk = document.getElementById('produk').value;
    const harga = document.getElementById('harga').value;
    
    if (!produk) {
        e.preventDefault();
        alert('Silakan pilih produk terlebih dahulu!');
        return false;
    }
    
    if (harga == '0') {
        e.preventDefault();
        alert('Harga produk tidak valid!');
        return false;
    }
    
    // Konfirmasi sebelum submit
    const total = document.getElementById('totalDisplay').value;
    if (!confirm(`Konfirmasi pesanan dengan total ${total}?`)) {
        e.preventDefault();
        return false;
    }
});
</script>

</body>
</html>