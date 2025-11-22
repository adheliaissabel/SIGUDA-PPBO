<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
    <div class="container">
        <!-- Link ke dashboard -->
        <a class="navbar-brand fw-bold" href="dashboard.php">
            <i class="bi bi-box-seam"></i> SIGUDA PPBO
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="KategoriController.php">Kategori</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ProdukController.php">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="TransaksiController.php">Transaksi</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <!-- Tombol Logout -->
                    <a class="nav-link btn btn-danger text-white btn-sm px-3 shadow-sm" href="logout.php" onclick="return confirm('Yakin ingin logout?')">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>