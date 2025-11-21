<?php
// views/produk/cetak.php
// Cek apakah data dikirim dari controller
if (!isset($stmt)) {
    echo "Error: Data tidak ditemukan. Silakan akses lewat tombol Cetak di halaman Produk.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Produk</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        h2 { margin: 0; }
        p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* CSS Khusus Cetak: Sembunyikan tombol saat diprint */
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">🖨️ Cetak Laporan</button>
    </div>

    <div class="header">
        <h2>LAPORAN STOK PRODUK GUDANG FASHION</h2>
        <p>Tanggal Cetak: <?php echo date('d/m/Y H:i'); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th>Kode</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th class="text-center">Ukuran</th>
                <th class="text-center">Stok</th>
                <th class="text-right">Harga Beli (Modal)</th>
                <th class="text-right">Total Aset</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $grand_total = 0;

            // PERBAIKAN: Gunakan while loop dan $stmt (bukan foreach $data)
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
                
                // Ambil harga beli, jika kosong pakai 0
                $harga = $row['harga_beli'] ?? 0;
                
                // Hitung total nilai per item
                $subtotal = $row['stok'] * $harga;
                
                // Tambahkan ke Grand Total
                $grand_total += $subtotal;
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['kode_produk'] ?? '-'); ?></td>
                <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                <td><?= htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                <td class="text-center"><?= htmlspecialchars($row['ukuran']); ?></td>
                <td class="text-center"><?= $row['stok']; ?></td>
                <td class="text-right">Rp <?= number_format($harga, 0, ',', '.'); ?></td>
                <td class="text-right">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>
            <?php endwhile; ?>
            
            <tr>
                <th colspan="7" class="text-right">TOTAL NILAI ASET STOK</th>
                <th class="text-right">Rp <?= number_format($grand_total, 0, ',', '.'); ?></th>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 30px; float: right; text-align: center; width: 200px;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p>( Admin Gudang )</p>
    </div>

</body>
</html>