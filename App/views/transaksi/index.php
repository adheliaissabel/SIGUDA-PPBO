<?php
// views/transaksi/index.php

// Cek apakah variabel $stmt ada dari Controller
if (!isset($stmt)) {
    echo "<div class='alert alert-danger'>Error: Silakan akses halaman ini melalui Controller (TransaksiController.php).</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi - SIGUDA PPBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>

    <?php include __DIR__ . '/../layouts/navbar.php'; ?>

    <div class="container mt-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <h2><i class="bi bi-arrow-left-right"></i> Data Transaksi</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="TransaksiController.php?action=create" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Transaksi
                </a>
                <a href="TransaksiController.php?action=cetak_laporan&start_date=<?= date('Y-m-01'); ?>&end_date=<?= date('Y-m-d'); ?>" target="_blank" class="btn btn-secondary">
                     <i class="bi bi-printer"></i> Cetak Laporan Bulan Ini
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
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Jumlah</th>
                                <th>Keterangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            // PERBAIKAN: Gunakan $stmt dan while loop
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($row['kode_transaksi'] ?? '-'); ?></span></td>
                                <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($row['nama_produk']); ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($row['ukuran']); ?></small>
                                </td>
                                <td class="text-center">
                                    <?php if($row['jenis_transaksi'] == 'masuk'): ?>
                                        <span class="badge bg-success"><i class="bi bi-arrow-down"></i> Masuk</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="bi bi-arrow-up"></i> Keluar</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center fw-bold"><?= $row['jumlah']; ?></td>
                                <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                <td class="text-center">
                                    <a href="TransaksiController.php?action=delete&id=<?= $row['id_transaksi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus transaksi ini?')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>

                            <?php if($no == 1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox display-4"></i><br>
                                    Belum ada data transaksi.
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