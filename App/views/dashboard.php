<?php
// Pastikan Model sudah dimuat dari Controller
$database = new Database();
$db = $database->getConnection();

$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksi = new Transaksi($db);

// Hitung Data
$total_produk = $produk->readAll()->rowCount();
$total_kategori = $kategori->readAll()->rowCount();
$total_transaksi = $transaksi->readAll()->rowCount();

// Hitung Nilai Aset
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
    <title>Dashboard Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    
    <?php 
    // PERBAIKAN PATH NAVBAR
    // Karena file ini ada di 'app/views/', dan navbar ada di 'app/views/layouts/'
    // Maka kita langsung masuk ke folder 'layouts', TIDAK PERLU mundur (../)
    include __DIR__ . '/layouts/navbar.php'; 
    ?>

    <div class="container mt-4">
        <!-- Kartu Ucapan -->
        <div class="card shadow-sm border-0 mb-4 bg-white">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-primary">
                    <i class="bi bi-person-circle display-4"></i>
                </div>
                <div>
                    <h4 class="mb-1">Selamat Datang, <strong><?php echo htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Admin'); ?></strong>!</h4>
                    <p class="text-muted mb-0">Anda login sebagai Administrator Gudang.</p>
                </div>
            </div>
        </div>
        
        <!-- Statistik -->
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam display-4 mb-2"></i>
                        <h5 class="card-title">Total Produk</h5>
                        <h2 class="fw-bold"><?php echo $total_produk; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-tags display-4 mb-2"></i>
                        <h5 class="card-title">Total Kategori</h5>
                        <h2 class="fw-bold"><?php echo $total_kategori; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-arrow-left-right display-4 mb-2"></i>
                        <h5 class="card-title">Transaksi</h5>
                        <h2 class="fw-bold"><?php echo $total_transaksi; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3 h-100 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-stack display-4 mb-2"></i>
                        <h5 class="card-title">Estimasi Aset</h5>
                        <h4>Rp <?php echo number_format($total_nilai_stok, 0, ',', '.'); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shortcut Cepat -->
        <div class="row mt-4">
            <div class="col-12">
                <h5 class="mb-3 text-muted">Aksi Cepat</h5>
            </div>
            <div class="col-md-4">
                <a href="ProdukController.php?action=create" class="btn btn-outline-primary w-100 py-3 mb-2">
                    <i class="bi bi-plus-lg"></i> Tambah Produk Baru
                </a>
            </div>
            <div class="col-md-4">
                <a href="TransaksiController.php?action=create" class="btn btn-outline-success w-100 py-3 mb-2">
                    <i class="bi bi-arrow-left-right"></i> Input Transaksi (Masuk/Keluar)
                </a>
            </div>
            <div class="col-md-4">
                <a href="ProdukController.php?action=cetak" target="_blank" class="btn btn-outline-dark w-100 py-3 mb-2">
                    <i class="bi bi-printer"></i> Cetak Laporan Stok
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>