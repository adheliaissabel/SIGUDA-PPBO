<?php
session_start();

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// 2. Panggil File Tampilan Asli
// Posisi: public/
// Target: views/transaksi/dashboard.php (Mundur ke root, masuk views, masuk transaksi)
require_once __DIR__ . '/../views/transaksi/dashboard.php';
?>