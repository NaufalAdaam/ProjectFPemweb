<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Home.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(51, 51, 51)">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#"><s>TheOrbits</s></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="aboutus.php">Tentang Kami</a></li>
          <li class="nav-item"><a class="nav-link" href="produk.php">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="form.php">Form Pemesanan</a></li>
          <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak Kami</a></li>
         <li class="nav-item"><a class="btn btn-outline-light ms-3 active" href="riwayatpembelian.php">Status Pembelian</a></li>
          
          <li class="nav-item"><a class="btn btn-danger btn-sm ms-3" href="../logout.php">Logout</a></li> 
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<div class="hero position-relative text-center text-white" style="height: 100vh; overflow: hidden;">
  <img src="image/Desain tanpa judul 2.png" 
       alt="Hero Image" 
       class="position-absolute top-0 start-0 w-100 h-100" 
       style="object-fit: cover; z-index: -2;">

  <div class="overlay" style="
       position: absolute;
       top: 0; left: 0; right: 0; bottom: 0;
       background-color: rgba(0, 0, 0, 0.6);
       z-index: -1;"></div>

  <div class="hero-content container d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
    <h1 class="display-5 fw-bold">WELCOME TO <s>THEORBITS</s></h1>
    <p class="lead">Orbit Determined By The Universe.</p>
    <button class="button type1 mt-3" onclick="window.location.href='produk.php'">
      <span class="btn-txt">Lihat Produk</span>
    </button>
  </div>
</div>



<!-- Footer -->
<div class="footer bg-dark text-white py-4">
  <div class="container text-center">
    <h5>Ikuti Kami</h5>
    <ul class="list-inline">
      <li class="list-inline-item"><a href="#" class="text-white fs-4 me-3"><i class="fab fa-instagram"></i></a></li>
      <li class="list-inline-item"><a href="#" class="text-white fs-4 me-3"><i class="fab fa-twitter"></i></a></li>
      <li class="list-inline-item"><a href="#" class="text-white fs-4"><i class="fab fa-facebook"></i></a></li>
    </ul>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
