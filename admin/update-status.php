<?php
require '../db.php'; // koneksi ke database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Validasi input - sesuaikan dengan enum di database
    $valid_statuses = ['Pending', 'Proces', 'Delivered', 'Completed'];
    if (!in_array($status, $valid_statuses)) {
        die("Status tidak valid.");
    }

    // Update status pesanan
    $stmt = $pdo->prepare("UPDATE pesanan SET status_pesanan = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    // Redirect kembali ke halaman orders
    header("Location: neworder.php");
    exit;
}
?>