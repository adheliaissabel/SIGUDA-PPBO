<?php
// Inisialisasi Database & Models dilakukan di sini agar data fresh
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
    <title>Dashboard Gudang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php 
    // Path Navbar juga harus benar
    $navbar_path = __DIR__ . '/../../layouts/navbar.php';
    if(file_exists($navbar_path)) include $navbar_path;
    ?>

    <div class="container mt-4">
        <div class="alert alert-success">
            Selamat Datang, <strong><?php echo $_SESSION['nama_lengkap'] ?? 'User'; ?></strong>
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Produk</h5>
                        <h2><?php echo $total_produk; ?></h2>
                    </div>
                </div>
            </div>
            </div>
    </div>
</body>
</html>