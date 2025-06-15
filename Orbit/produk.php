<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="produk.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgb(51, 51, 51)">
        <div class="container">
          <a class="navbar-brand fw-bold" href="#"><s>TheOrbits</s></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="aboutus.php">Tentang Kami</a></li>
          <li class="nav-item"><a class="nav-link active" href="produk.php">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="form.php">Form Pemesanan</a></li>
          <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak Kami</a></li>
          <li class="nav-item"><a class="btn btn-outline-light ms-3 active" href="riwayatpembelian.php">Status Pembelian</a></li>
          <li class="nav-item"><a class="btn btn-danger btn-sm ms-3" href="../logout.php">Logout</a></li>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="main">
        <div class="product">
          <div class="discount-tag">-70%</div>
        
          <div id="carouselProduk1" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner rounded">
              <div class="carousel-item active">
                <img src="image/desain baju pertama.png" class="d-block w-100" alt="Produk 1 - Depan">
              </div>
              <div class="carousel-item">
                <img src="image/Pertama belakang.png" class="d-block w-100" alt="Produk 1 - Belakang">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduk1" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselProduk1" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
          </div>
        
          <h4>Orbital Path</h4>
          <div class="old-price">Rp 300.000</div>
          <div class="price">Rp 90.000</div>
        </div>        
          </div>
          
          <div class="main">
          <div class="product">
            <div class="discount-tag">-60%</div>
            <div class="sold-out">SOLD OUT</div>
          
            <div id="carouselProduk2" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner rounded">
                <div class="carousel-item active">
                  <img src="image/desain kedua depan.png" class="d-block w-100" alt="Produk 2 - Depan">
                </div>
                <div class="carousel-item">
                  <img src="image/desain kedua belakang.png" class="d-block w-100" alt="Produk 2 - Belakang">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselProduk2" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselProduk2" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </button>
            </div>
          
          
            <h4>The Nature of the black hole</h4>
            <div class="old-price">Rp 400.000</div>
            <div class="price">Rp 160.000</div>
          </div>
        </div>

          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
