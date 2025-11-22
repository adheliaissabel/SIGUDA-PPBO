<?php
session_start();

// Cek Login
if(!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login di public
    // Path: views/transaksi -> views -> root -> public/index.php
    header("Location: ../../public/index.php"); 
    exit();
}

// --- PERBAIKAN PATH (JALUR FILE) ---
// Posisi File ini: /app/views/transaksi/
// Target: /app/App/core/database.php

require_once __DIR__ . '/../../App/core/database.php';
require_once __DIR__ . '/../../App/models/Produk.php';
require_once __DIR__ . '/../../App/models/Kategori.php';
require_once __DIR__ . '/../../App/models/Transaksi.php';

$database = new Database();
$db = $database->getConnection();

if ($db == null) { 
    die("Gagal koneksi database. Cek variabel Railway."); 
}

$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksi = new Transaksi($db);

// Hitung Statistik
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
    
    <!-- Navbar -->
    <!-- Posisi: views/transaksi/ -->
    <!-- Target: views/layouts/navbar.php (Mundur 1 langkah) -->
    <?php include __DIR__ . '/../layouts/navbar.php'; ?>

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
        
        <!-- Tabel Stok Menipis -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle"></i> Stok Menipis (< 10)</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Produk</th>
                                        <th class="text-center">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Pastikan method getLowStock ada
                                    if(method_exists($produk, 'getLowStock')):
                                        $stmt_low = $produk->getLowStock(10);
                                        if($stmt_low->rowCount() > 0):
                                            while($row = $stmt_low->fetch(PDO::FETCH_ASSOC)): 
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['kode_produk'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
                                        <td class="text-center"><span class="badge bg-danger rounded-pill"><?php echo $row['stok']; ?></span></td>
                                    </tr>
                                    <?php 
                                            endwhile; 
                                        else:
                                    ?>
                                    <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada stok menipis</td></tr>
                                    <?php endif; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaksi Terakhir -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-primary"><i class="bi bi-clock-history"></i> 5 Transaksi Terakhir</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Jenis</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $stmt_recent = $transaksi->readAll(); 
                                    $count = 0;
                                    if($stmt_recent->rowCount() > 0):
                                        while($row = $stmt_recent->fetch(PDO::FETCH_ASSOC)): 
                                            if($count >= 5) break;
                                            $count++;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['kode_transaksi'] ?? $row['id_transaksi']); ?></td>
                                        <td>
                                            <?php if($row['jenis_transaksi'] == 'masuk'): ?>
                                                <span class="badge bg-success"><i class="bi bi-arrow-down"></i> Masuk</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger"><i class="bi bi-arrow-up"></i> Keluar</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                    </tr>
                                    <?php 
                                        endwhile; 
                                    else:
                                    ?>
                                    <tr><td colspan="3" class="text-center text-muted py-3">Belum ada transaksi</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>