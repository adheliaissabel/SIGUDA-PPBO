<?php
session_start();

// Cek Login
if(!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// --- BAGIAN PENTING: LOAD DEPENDENCIES ---
// Menggunakan __DIR__ untuk path absolut yang aman
// Struktur: keluar public (..) -> masuk app -> masuk config/models

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/models/Produk.php';
require_once __DIR__ . '/../app/models/Kategori.php';
require_once __DIR__ . '/../app/models/Transaksi.php';

// --- BAGIAN LOAD VIEW ---
// Arahkan ke file tampilan dashboard yang ada di folder views
// Pastikan anda sudah memindahkan file tampilan dashboard ke: app/views/transaksi/dashboard.php
$view_dashboard = __DIR__ . '/../app/views/transaksi/dashboard.php';

if (file_exists($view_dashboard)) {
    require_once $view_dashboard;
} else {
    echo "Error: File view dashboard tidak ditemukan di: $view_dashboard";
    echo "<br>Pastikan Anda sudah memindahkan file tampilan ke folder app/views/transaksi/";
}
?>