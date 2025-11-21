<?php
// views/kategori/edit.php

// Cek apakah data kategori ada (dikirim dari Controller)
if (!isset($kategori)) {
    echo "<div class='alert alert-danger'>Error: Data kategori tidak ditemukan. Silakan akses lewat Controller.</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - SIGUDA PPBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>

    <?php include __DIR__ . '/../layouts/navbar.php'; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Kategori</h4>
                    </div>
                    <div class="card-body">
                        
                        <form method="POST" action="KategoriController.php?action=edit&id=<?= $kategori->id_kategori; ?>">
                            
                            <div class="mb-4">
                                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control form-control-lg" id="nama_kategori" name="nama_kategori" 
                                       value="<?= htmlspecialchars($kategori->nama_kategori); ?>" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="KategoriController.php?action=index" class="btn btn-secondary me-md-2">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Update Kategori
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