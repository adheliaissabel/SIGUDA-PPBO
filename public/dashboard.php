<?php
session_start();

// ... code login ...

// Ganti 'App' menjadi 'app' (huruf kecil semua)
require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/models/Produk.php';
require_once __DIR__ . '/../app/models/Kategori.php';
require_once __DIR__ . '/../app/models/Transaksi.php';

// ... code database ...

// Ganti 'App' menjadi 'app'
require_once __DIR__ . '/app/views/transaksi/dashboard.php';
?>