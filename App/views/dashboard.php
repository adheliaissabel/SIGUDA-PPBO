<?php
session_start();

// Cek apakah user sudah login
if(!isset($_SESSION['user_id'])) {
    // Arahkan ke public/index.php (Login)
    header("Location: ../public/index.php");
    exit();
}

// --- PERBAIKAN PATH (JALUR FILE) ---
// Kita harus masuk ke folder App (Huruf Besar)
// __DIR__ . '/../' artinya mundur dari folder views ke root

require_once __DIR__ . '/../App/core/database.php';
require_once __DIR__ . '/../App/models/Produk.php';
require_once __DIR__ . '/../App/models/Kategori.php';
require_once __DIR__ . '/../App/models/Transaksi.php';

// Inisialisasi Database
$database = new Database();
$db = $database->getConnection();

// Cek Koneksi
if ($db == null) {
    die("Gagal koneksi database di Dashboard.");
}

$produk = new Produk($db);
$kategori = new Kategori($db);
$transaksi = new Transaksi($db);

// Hitung Total Data
$stmt_produk = $produk->readAll();
$total_produk = $stmt_produk->rowCount();

$stmt_kategori = $kategori->readAll();
$total_kategori = $stmt_kategori->rowCount();

$stmt_transaksi = $transaksi->readAll();
$total_transaksi = $stmt_transaksi->rowCount();

// Hitung Total Nilai Stok
$stmt_nilai = $produk->readAll();
$total_nilai_stok = 0;

while($row = $stmt_nilai->fetch(PDO::FETCH_ASSOC)) {
    // Gunakan harga_beli jika ada, jika tidak gunakan harga_jual (atau 0)
    $harga_hitung = isset($row['harga_beli']) && $row['harga_beli'] > 0 ? $row['harga_beli'] : ($row['harga_jual'] ?? 0);
    $total_nilai_stok += ($row['stok'] * $harga_hitung);
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
    
    <?php include 'layouts/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="card-title">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>!</h4>
                        <p class="text-muted mb-0">Anda login sebagai <strong><?php echo ucfirst($_SESSION['role']); ?></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3 h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Total Produk</h6>
                                <h2 class="mt-2 mb-0"><?php echo $total_produk; ?></h2>
                            </div>
                            <i class="bi bi-box-seam display-4 opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-primary border-0">
                        <a href="../public/ProdukController.php" class="text-white text-decoration-none small">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-success mb-3 h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Total Kategori</h6>
                                <h2 class="mt-2 mb-0"><?php echo $total_kategori; ?></h2>
                            </div>
                            <i class="bi bi-tags display-4 opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-success border-0">
                        <a href="../public/KategoriController.php" class="text-white text-decoration-none small">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3 h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Total Transaksi</h6>
                                <h2 class="mt-2 mb-0"><?php echo $total_transaksi; ?></h2>
                            </div>
                            <i class="bi bi-arrow-left-right display-4 opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-warning border-0">
                        <a href="../public/TransaksiController.php" class="text-white text-decoration-none small">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-white bg-info mb-3 h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">Nilai Aset Stok</h6>
                                <h4 class="mt-2 mb-0">Rp <?php echo number_format($total_nilai_stok, 0, ',', '.'); ?></h4>
                            </div>
                            <i class="bi bi-cash-coin display-4 opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-info border-0">
                        <small class="text-white">Estimasi nilai modal</small>
                    </div>
                </div>
            </div>
        </div>

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
                                    // Pastikan method getLowStock ada di model Produk
                                    // Jika error, cek apakah method ini sudah dibuat di App/models/Produk.php
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
                                    <?php endif; 
                                    else: ?>
                                    <tr><td colspan="3" class="text-center text-danger">Method getLowStock() belum dibuat di Model Produk.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

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