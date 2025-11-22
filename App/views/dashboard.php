<?php
// Pastikan session start hanya dipanggil sekali
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek Login (Backup security)
if(!isset($_SESSION['user_id'])) {
    header("Location: ../../../public/index.php");
    exit();
}

// --- PERBAIKAN PATH ---
// Posisi: App/views/transaksi/
// Target: App/core/database.php

// Gunakan __DIR__ untuk path absolut yang lebih aman
// Mundur 2 langkah: App/views/transaksi -> App/views -> App
require_once __DIR__ . '/../../core/database.php';
require_once __DIR__ . '/../../models/Produk.php';
require_once __DIR__ . '/../../models/Kategori.php';
require_once __DIR__ . '/../../models/Transaksi.php';

$database = new Database();
$db = $database->getConnection();

if ($db == null) { die("Gagal koneksi database."); }

$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksi = new Transaksi($db);

// ... (Sisa kode logika dashboard sama seperti sebelumnya)
// Hitung Data
$total_produk = $produk->readAll()->rowCount();
$total_kategori = $kategori->readAll()->rowCount();
$total_transaksi = $transaksi->readAll()->rowCount();

$stmt_nilai = $produk->readAll();
$total_nilai_stok = 0;
while($row = $stmt_nilai->fetch(PDO::FETCH_ASSOC)) {
    $harga = $row['harga_beli'] > 0 ? $row['harga_beli'] : ($row['harga_jual'] ?? 0);
    $total_nilai_stok += ($row['stok'] * $harga);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SIGUDA PPBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    
    <!-- Navbar -->
    <!-- Asumsi navbar ada di App/views/layouts/navbar.php -->
    <?php 
    $navbar_path = __DIR__ . '/../../views/layouts/navbar.php';
    if (file_exists($navbar_path)) {
        include $navbar_path; 
    } else {
        // Fallback path
        include __DIR__ . '/../layouts/navbar.php';
    }
    ?>

    <div class="container mt-4">
        <!-- Welcome Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="card-title">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>!</h4>
                <p class="text-muted mb-0">Anda login sebagai <strong><?php echo ucfirst($_SESSION['role']); ?></strong></p>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Total Produk</h6>
                        <h2><?php echo $total_produk; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Total Kategori</h6>
                        <h2><?php echo $total_kategori; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Total Transaksi</h6>
                        <h2><?php echo $total_transaksi; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3 h-100 shadow-sm">
                    <div class="card-body">
                        <h6 class="card-title">Nilai Aset</h6>
                        <h4>Rp <?php echo number_format($total_nilai_stok, 0, ',', '.'); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>