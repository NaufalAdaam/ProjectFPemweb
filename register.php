<?php
session_start();
require 'db.php'; // pastikan $pdo tersedia

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username        = trim($_POST['username'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Validasi input kosong
    if (empty($username) || empty($email) || empty($password)) {
        $message = "Semua field harus diisi.";
    } elseif ($password !== $confirmPassword) {
        $message = "Password dan konfirmasi tidak sama.";
    } else {
        // Cek apakah username/email sudah terdaftar
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute([
            'username' => $username,
            'email'    => $email
        ]);
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $message = "Username atau email sudah digunakan.";
        } else {
            // Hash password dan simpan
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");

            try {
                $stmt->execute([$username, $email, $hashedPassword]);
                $message = "Pendaftaran berhasil! <a href='login.php'>Login sekarang</a>.";
            } catch (PDOException $e) {
                $message = "Terjadi kesalahan saat menyimpan data: " . $e->getMessage();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, grey, grey);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #ff3c00;
    }
    .btn-success {
      background-color: #ff3c00;
      border: none;
    }
    .btn-success:hover {
      background-color: #e63700 !important;
    }
    a {
      color: #ff3c00;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-5">
        <div class="card p-4">
          <h4 class="text-center mb-4">Register</h4>

          <?php if ($message): ?>
            <div class="alert alert-warning"><?= $message ?></div>
          <?php endif; ?>

          <form method="POST" action="">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-success">Register</button>
            </div>
            <div class="mt-3 text-center">
              Already have an account? <a href="login.php">Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
