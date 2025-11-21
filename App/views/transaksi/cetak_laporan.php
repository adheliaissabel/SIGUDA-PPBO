<?php
// views/transaksi/cetak_laporan.php

// Cek apakah data dikirim dari Controller
if (!isset($data)) {
    echo "Error: Data laporan tidak ditemukan. Silakan akses lewat menu Cetak Laporan.";
    exit;
}

// Helper untuk format tanggal Indonesia
function tgl_indo($tanggal){
    $bulan = array (
        1 =>   'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - SIGUDA PPBO</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 12pt;
            margin: 20px;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h2, .header h3 {
            margin: 0;
            text-transform: uppercase;
        }
        .info-periode {
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: middle;
        }
        th {
            background-color: #f0f0f0; /* Warna abu-abu tipis untuk header tabel */
            font-weight: bold;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .badge {
            padding: 2px 5px;
            border: 1px solid #000;
            font-size: 10pt;
            border-radius: 3px;
        }
        
        /* CSS KHUSUS PRINT */
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
        
        /* Tombol Cetak Style */
        .btn-print {
            background-color: #0d6efd;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .btn-print:hover { background-color: #0b5ed7; }
    </style>
</head>
<body>

    <button onclick="window.print()" class="no-print btn-print">
        🖨️ Cetak Laporan / Simpan PDF
    </button>

    <div class="header">
        <h2>LAPORAN TRANSAKSI BARANG</h2>
        <h3>GUDANG FASHION PPBO</h3>
        <small>Jl. Contoh Alamat Gudang No. 123, Kota Coding</small>
    </div>

    <div class="info-periode">
        <strong>Periode Laporan:</strong> 
        <?php echo tgl_indo($start_date); ?> s/d <?php echo tgl_indo($end_date); ?>
        <br>
        <strong>Tanggal Cetak:</strong> <?php echo tgl_indo(date('Y-m-d')); ?> Pukul <?php echo date('H:i'); ?> WIB
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Nama Produk</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if(count($data) > 0):
                foreach($data as $row): 
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                <td class="text-center"><?= htmlspecialchars($row['kode_transaksi'] ?? '-'); ?></td>
                <td>
                    <?= htmlspecialchars($row['nama_produk']); ?><br>
                    <small>Ukuran: <?= htmlspecialchars($row['ukuran']); ?></small>
                </td>
                <td class="text-center">
                    <?php if($row['jenis_transaksi'] == 'masuk'): ?>
                        <span style="color: green; font-weight: bold;">MASUK</span>
                    <?php else: ?>
                        <span style="color: red; font-weight: bold;">KELUAR</span>
                    <?php endif; ?>
                </td>
                <td class="text-center font-weight-bold"><?= $row['jumlah']; ?></td>
                <td><?= htmlspecialchars($row['keterangan']); ?></td>
            </tr>
            <?php 
                endforeach; 
            else:
            ?>
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">
                    <em>Tidak ada data transaksi pada periode ini.</em>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 50px; float: right; width: 200px; text-align: center;">
        <p>Mengetahui,</p>
        <p>Kepala Gudang</p>
        <br><br><br><br>
        <p><strong>( <?php echo $_SESSION['nama_lengkap'] ?? 'Administrator'; ?> )</strong></p>
    </div>

</body>
</html>