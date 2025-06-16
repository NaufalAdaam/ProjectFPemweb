<?php
// Konfigurasi database
$host = 'db.be-mons1.bengt.wasmernet.com';
$Port: '3306';
$dbname = 'db_login';    // ganti sesuai database kamu
$username = 'fc49728c7e60800026636bc170db';         // default user XAMPP
$password = '0684fc49-728d-7028-8000-5a0b2d3fae8e';             // kosongkan jika tidak ada password

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

// Opsi tambahan (opsional, tapi direkomendasikan)
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,           // Aktifkan error mode exception
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      // Ambil data sebagai array asosiatif
    PDO::ATTR_EMULATE_PREPARES => false                    // Gunakan prepared statements asli
];

// Buat koneksi PDO
try {


    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "error" => "Database connection failed: " . $e->getMessage()

    ]);
    exit;
}
?>
