<?php
// views/produk/create.php
// Pastikan akses variabel dari controller tersedia
if (!isset($stmt_kategori)) {
    // Jika diakses langsung tanpa controller, redirect atau stop
    echo "<div class='alert alert-danger'>Akses Ditolak. Buka lewat Controller.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - SIGUDA PPBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php include __DIR__ . '/../layouts/navbar.php'; ?>

    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Tambah Produk Baru</h4>
                    </div>
                    <div class="card-body">
                        
                        <form method="POST" action="ProdukController.php?action=create">
                            
                            <div class="mb-3">
                                <label class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select name="kategori_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php 
                                    // PERBAIKAN: Menggunakan $stmt_kategori dari Controller
                                    while($kat = $stmt_kategori->fetch(PDO::FETCH_ASSOC)): 
                                    ?>
                                        <option value="<?= $kat['id_kategori']; ?>">
                                            <?= htmlspecialchars($kat['nama_kategori']); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kode Produk <span class="text-danger">*</span></label>
                                    <input type="text" name="kode_produk" class="form-control" placeholder="Contoh: P-001" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_produk" class="form-control" placeholder="Nama barang..." required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ukuran <span class="text-danger">*</span></label>
                                    <input type="text" name="ukuran" class="form-control" placeholder="S, M, L, XL, dll" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Warna</label>
                                    <input type="text" name="warna" class="form-control" placeholder="Hitam, Putih, dll">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stok Awal <span class="text-danger">*</span></label>
                                    <input type="number" name="stok" class="form-control" min="0" value="0" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Harga Beli (Modal)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_beli" class="form-control" min="0" value="0">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_jual" class="form-control" min="0" value="0" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Keterangan tambahan produk..."></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="ProdukController.php" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Produk</button>
                            </div>

                        </form>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>