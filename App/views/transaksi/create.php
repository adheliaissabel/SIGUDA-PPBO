<?php
// views/transaksi/create.php

// Cek apakah variabel $produkList ada (dikirim dari Controller)
if (!isset($produkList)) {
    echo "<div class='alert alert-danger'>Error: Silakan akses halaman ini melalui Controller (TransaksiController.php).</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi - SIGUDA PPBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>

    <?php include __DIR__ . '/../layouts/navbar.php'; ?>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-cart-plus"></i> Tambah Transaksi Baru</h4>
                    </div>
                    <div class="card-body">
                        
                        <form method="POST" action="TransaksiController.php?action=create">
                            
                            <div class="mb-3">
                                <label for="id_produk" class="form-label">Produk <span class="text-danger">*</span></label>
                                <select name="id_produk" id="id_produk" class="form-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    <?php foreach($produkList as $prod): ?>
                                        <option value="<?= $prod['id_produk']; ?>">
                                            <?= htmlspecialchars($prod['nama_produk']); ?> 
                                            (Ukuran: <?= $prod['ukuran']; ?>) - 
                                            Stok Saat Ini: <?= $prod['stok']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">Pilih produk yang akan ditransaksikan.</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="jenis_transaksi" class="form-label">Jenis Transaksi <span class="text-danger">*</span></label>
                                    <select name="jenis_transaksi" id="jenis_transaksi" class="form-select" required>
                                        <option value="masuk" class="text-success fw-bold">Barang Masuk (+ Stok)</option>
                                        <option value="keluar" class="text-danger fw-bold">Barang Keluar (- Stok)</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="jumlah" class="form-label">Jumlah <span class="text-danger">*</span></label>
                                    <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" placeholder="Contoh: 10" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Contoh: Kulakan dari supplier A, atau Terjual ke Bpk Budi"></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="TransaksiController.php?action=index" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Transaksi
                                </button>
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