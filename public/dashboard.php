<?php
session_start();

// ... (kode cek login biarkan saja) ...

// --- PERBAIKAN PATH (Pakai 'App' besar) ---

// Arahkan ke Config & Model
require_once __DIR__ . '/../App/config/database.php';
require_once __DIR__ . '/../App/models/Produk.php';
require_once __DIR__ . '/../App/models/Kategori.php';
require_once __DIR__ . '/../App/models/Transaksi.php';

// ... (kode inisialisasi database biarkan saja) ...

// --- BARIS 13 YANG ERROR TADI ---
// Arahkan ke View (Tampilan)
require_once __DIR__ . '/../App/views/transaksi/dashboard.php';
?>