<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="kontak.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
          <li class="nav-item"><a class="nav-link" href="produk.php">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="form.php">Form Pemesanan</a></li>
          <li class="nav-item"><a class="nav-link active" href="kontak.php">Kontak Kami</a></li>
          <li class="nav-item"><a class="btn btn-outline-light ms-3 active" href="riwayatpembelian.php">Status Pembelian</a></li>
          <li class="nav-item"><a class="btn btn-danger btn-sm ms-3" href="../logout.php">Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <style>
        body {
          background-color: #f0f0f0;
          font-family: 'Segoe UI', sans-serif;
        }
        .contact-card {
          background-color: #1f1f1f;
          color: white;
          border-radius: 20px;
          padding: 40px;
          max-width: 400px;
          margin: 50px auto;
          box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }
        .contact-card h2 {
          text-align: center;
          margin-bottom: 30px;
        }
        .contact-item {
          display: flex;
          align-items: center;
          margin-bottom: 25px;
          border-bottom: 1px dashed #ccc;
          padding-bottom: 10px;
        }
        .contact-item i {
          color: #ffc107; /* Kuning */
          font-size: 1.5rem;
          margin-right: 15px;
          width: 30px;
          text-align: center;
        }
        .contact-text {
          color: #ffffff;
        }
      </style>
    </head>
    <body>
    
      <div class="contact-card">
        <h2>Hubungi Kami</h2>
    
        <div class="contact-item">
          <i class="fab fa-instagram"></i>
          <span class="contact-text">TheOrbits.Official</span>
        </div>
    
        <div class="contact-item">
          <i class="fas fa-phone-alt"></i>
          <span class="contact-text">089963732536</span>
        </div>
    
        <div class="contact-item">
          <i class="fab fa-twitter"></i>
          <span class="contact-text">TheOrbits_Official</span>
        </div>
    
        <div class="contact-item">
          <i class="fab fa-facebook"></i>
          <span class="contact-text">TheOrbitsOfficial</span>
        </div>
      </div>


      <div class="footer text-white py-4">
        <div class="container text-center">
          <h5>Ikuti Kami</h5>
          <ul class="list-inline mb-0">
            <li class="list-inline-item">
              <a href="#" class="text-white fs-4 me-3"><i class="fab fa-instagram"></i></a>
            </li>
            <li class="list-inline-item">
              <a href="#" class="text-white fs-4 me-3"><i class="fab fa-twitter"></i></a>
            </li>
            <li class="list-inline-item">
              <a href="#" class="text-white fs-4"><i class="fab fa-facebook"></i></a>
            </li>
          </ul>
        </div>
      </div>
    

</body>
</html>