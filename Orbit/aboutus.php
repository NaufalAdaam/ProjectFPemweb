<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang Kami</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="aboutus.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <!-- Navbar disamakan dengan halaman Home -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(51, 51, 51)">
    <div class="container">
      <a class="navbar-brand fw-bold text-white" href="#"><s>TheOrbits</s></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span> 
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="aboutus.php">Tentang Kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="produk.php">Produk</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="form.php">Form Pemesanan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="kontak.php">Kontak Kami</a>
          </li>
         <li class="nav-item"><a class="btn btn-outline-light ms-3 active" href="riwayatpembelian.php">Status Pembelian</a></li>
          <li class="nav-item"><a class="btn btn-danger btn-sm ms-3" href="../logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bagian Tentang Kami -->
  <section id="about-us" class="p-5">
    <h2 class="mb-3">Tentang Kami</h2>
    <p><s>THEORBITS</s> adalah brand fashion yang terinspirasi dari keajaiban luar angkasa. Kami hadir untuk membawa semangat eksplorasi, keunikan galaksi, dan misteri semesta ke dalam setiap detail pakaian yang kami ciptakan.</p>

    <p>Didirikan dengan semangat kosmik dan gaya futuristik, <s>THEORBITS</s> menggabungkan desain artistik bertema luar angkasa dengan kenyamanan serta kualitas bahan premium. Setiap koleksi kami adalah representasi visual dari bintang-bintang, planet, orbit, hingga black hole—mengajak kamu untuk berani tampil beda dan menjelajahi dunia mode tanpa batas.</p>

    <p>Kami percaya bahwa setiap individu adalah bintang dengan orbitnya masing-masing. Melalui <s>THEORBITS</s>, kami ingin membantu kamu menemukan gaya yang mencerminkan keunikan dan perjalanan pribadimu di semesta ini.</p>

    <p><em>Join the mission. Be part of <s>THEORBITS</s>.</em></p>
  </section>

  <div class="footer bg-dark text-white py-4">
    <div class="container text-center">
      <h5>Ikuti Kami</h5>
      <ul class="list-inline">
        <li class="list-inline-item"><a href="#" class="text-white fs-4 me-3"><i class="fab fa-instagram"></i></a></li>
        <!-- Ganti fa-x-twitter ke fa-twitter -->
        <li class="list-inline-item"><a href="#" class="text-white fs-4 me-3"><i class="fab fa-twitter"></i></a></li>
        <li class="list-inline-item"><a href="#" class="text-white fs-4"><i class="fab fa-facebook"></i></a></li>
      </ul>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
