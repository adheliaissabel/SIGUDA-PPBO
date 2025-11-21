<h2>Laporan Transaksi</h2>

<form method="POST">
    <label>Tanggal Mulai:</label>
    <input type="date" name="start_date" required>
    
    <label>Tanggal Akhir:</label>
    <input type="date" name="end_date" required>
    
    <button type="submit">Tampilkan</button>
</form>

<?php if(!empty($data)): ?>
<a href="index.php?page=transaksi&action=cetak_laporan&start_date=<?php echo $_POST['start_date']; ?>&end_date=<?php echo $_POST['end_date']; ?>" target="_blank" class="btn btn-success">🖨️ Cetak Laporan</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach($data as $row): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
            <td><?php echo $row['nama_produk'] . ' (' . $row['ukuran'] . ')'; ?></td>
            <td><?php echo $row['nama_kategori']; ?></td>
            <td style="color: <?php echo $row['jenis_transaksi'] == 'masuk' ? 'green' : 'red'; ?>">
                <?php echo strtoupper($row['jenis_transaksi']); ?>
            </td>
            <td><?php echo $row['jumlah']; ?></td>
            <td><?php echo $row['keterangan']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>