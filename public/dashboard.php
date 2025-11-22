<?php
session_start();

// ... code login ...

// Ganti 'App' menjadi 'app' (huruf kecil semua)
require_once __DIR__ . '/../App/config/database.php';
require_once __DIR__ . '/../App/models/Produk.php';
require_once __DIR__ . '/../App/models/Kategori.php';
require_once __DIR__ . '/../App/models/Transaksi.php';

// ... code database ...

// Ganti 'App' menjadi 'app'
require_once __DIR__ . '/App/views/transaksi/dashboard.php';
?>