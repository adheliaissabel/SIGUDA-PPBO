<?php
session_start();

// Cek Login
if(!isset($_SESSION['user_id'])) {
    header("Location: ../../public/index.php"); // Mundur 2 langkah ke public
    exit();
}

// --- PERBAIKAN PATH KHUSUS FOLDER TRANSAKSI ---
// Posisi: views/transaksi/
// Mundur 1 (../) => views/
// Mundur 2 (../../) => Root (/app)
// Baru masuk ke App/core

require_once __DIR__ . '/../../App/core/database.php';
require_once __DIR__ . '/../../App/models/Produk.php';
require_once __DIR__ . '/../../App/models/Kategori.php';
require_once __DIR__ . '/../../App/models/Transaksi.php';

$database = new Database();
$db = $database->getConnection();

if ($db == null) { die("Gagal koneksi database di Dashboard Transaksi."); }

$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksi = new Transaksi($db);

// Hitung Data
$total_produk = $produk->readAll()->rowCount();
$total_kategori = $kategori->readAll()->rowCount();
$total_transaksi = $transaksi->readAll()->rowCount();

// Hitung Nilai Stok
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
    
    <?php include __DIR__ . '/../layouts/navbar.php'; ?>

    <div class="container mt-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h4 class="card-title">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>!</h4>
                <p class="text-muted mb-0">Role: <strong><?php echo ucfirst($_SESSION['role']); ?></strong></p>
            </div>
        </div>

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