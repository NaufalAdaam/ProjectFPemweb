<?php
session_start();
require 'db.php'; // koneksi database

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Ambil user berdasarkan username
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Cek password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Arahkan berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: admin/index.php");
            } elseif ($user['role'] === 'user') {
                header("Location: Orbit/index.php");
            } else {
                header("Location: Orbit/index.php");
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Akun tidak ditemukan!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
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
      box-shadow: none ;
      border-color: #ff3c00;
    }
    .btn-primary {
      background-color: #ff3c00 ;
      border: none ;
    }
    .btn-primary:hover {
      background-color: #e63700 !important;
    }
    a {
      color: #ff3c00;
      text-decoration: none ;
    }
    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
      <div class="card p-4">
        <h4 class="text-center mb-4">Login</h4>

        <?php if ($error): ?>
          <div class="alert alert-danger">
            <?= $error ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="">
          <div class="mb-3">
            <label for="email" class="form-label">Email / Username</label>
            <input type="text" class="form-control" name="username" id="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" required>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Remember me</label>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <div class="mt-3 text-center">
           <a href="register.php">Register</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

</body>
</html>
