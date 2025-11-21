<?php
// views/produk/edit.php
// Pastikan akses melalui Controller
if (!isset($produk)) {
    exit("Error: Akses langsung tidak diizinkan.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - SIGUDA PPBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <?php include __DIR__ . '/../layouts/navbar.php'; ?>
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">Edit Produk</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php 
                                    // Menampilkan daftar kategori di dropdown
                                    while($kat = $stmt_kategori->fetch(PDO::FETCH_ASSOC)): 
                                        // Cek jika kategori ini adalah kategori produk saat ini, maka select
                                        $selected = ($kat['id_kategori'] == $produk->id_kategori) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $kat['id_kategori']; ?>" <?= $selected; ?>>
                                        <?= $kat['nama_kategori']; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kode Produk</label>
                                    <input type="text" name="kode_produk" class="form-control" value="<?= htmlspecialchars($produk->kode_produk ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($produk->nama_produk); ?>" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ukuran</label>
                                    <input type="text" name="ukuran" class="form-control" value="<?= htmlspecialchars($produk->ukuran); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Warna</label>
                                    <input type="text" name="warna" class="form-control" value="<?= htmlspecialchars($produk->warna ?? '-'); ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stok" class="form-control" value="<?= $produk->stok; ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Harga Beli</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_beli" class="form-control" value="<?= $produk->harga_beli ?? 0; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Harga Jual</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_jual" class="form-control" value="<?= $produk->harga_jual ?? 0; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($produk->deskripsi ?? ''); ?></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="ProdukController.php" class="btn btn-secondary me-2">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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