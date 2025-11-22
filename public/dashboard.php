<?php
session_start();

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// PANGGIL VIEW ASLI
// __DIR__ = public
// /../ = Mundur ke root
// /views/transaksi/dashboard.php = Masuk ke lokasi asli file
require_once __DIR__ . '/../views/transaksi/dashboard.php';
?>