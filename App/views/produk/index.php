<?php
// views/produk/index.php
// Pastikan file ini diakses melalui Controller, bukan langsung

// Cek apakah variable $stmt ada. Jika tidak, lempar error atau inisialisasi kosong.
if (!isset($stmt)) {
    echo "<div class='alert alert-danger'>Error: Data tidak ditemukan. Silakan akses lewat Controller.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - SIGUDA PPBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>

    <?php include '../views/layouts/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <h2><i class="bi bi-box-seam"></i> Data Produk</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="ProdukController.php?action=create" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Produk
                </a>
                <a href="ProdukController.php?action=cetak" target="_blank" class="btn btn-secondary">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
            </div>
        </div>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            // KITA GUNAKAN $stmt (bukan $data)
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($row['kode_produk'] ?? '-'); ?></span></td>
                                <td>
                                    <strong><?= htmlspecialchars($row['nama_produk']); ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($row['ukuran']); ?> | <?= htmlspecialchars($row['warna'] ?? '-'); ?></small>
                                </td>
                                <td><?= htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                                <td>
                                    <?php if($row['stok'] <= 10): ?>
                                        <span class="badge bg-danger"><?= $row['stok']; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?= $row['stok']; ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.'); ?></td>
                                <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <a href="ProdukController.php?action=edit&id=<?= $row['id_produk']; ?>" class="btn btn-warning btn-sm text-white" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="ProdukController.php?action=delete&id=<?= $row['id_produk']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>

                            <?php if($no == 1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox display-6"></i><br>
                                    Belum ada data produk. Silakan tambah data baru.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>