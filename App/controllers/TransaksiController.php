<?php
session_start();
require_once '../config/database.php';
require_once '../models/Transaksi.php';
require_once '../models/Produk.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Pastikan Anda sudah membuat file models/Transaksi.php
$transaksi = new Transaksi($db);
$produk = new Produk($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch($action) {
    case 'index':
        $stmt = $transaksi->readAll();
        include '../views/transaksi/index.php';
        break;
        
    case 'create':
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // PERBAIKAN: Logika disederhanakan sesuai database.sql yang Single Row
            $transaksi->id_produk = $_POST['id_produk'];
            $transaksi->jenis_transaksi = $_POST['jenis_transaksi'];
            $transaksi->jumlah = $_POST['jumlah'];
            $transaksi->tanggal = $_POST['tanggal'];
            $transaksi->keterangan = $_POST['keterangan'];
            
            // Generate Kode Transaksi Otomatis (Opsional, jika kolom kode_transaksi ada)
            // $transaksi->kode_transaksi = "TRX-" . time(); 
            
            if($transaksi->create()) {
                // Update Stok Produk
                // PERBAIKAN: Gunakan id_produk sesuai Model Produk
                $produk->id_produk = $_POST['id_produk'];
                
                if($_POST['jenis_transaksi'] == 'masuk') {
                    $produk->updateStok($_POST['jumlah'], 'tambah');
                } else {
                    $produk->updateStok($_POST['jumlah'], 'kurang');
                }
                
                $_SESSION['success'] = "Transaksi berhasil disimpan";
                header("Location: TransaksiController.php");
                exit();
            } else {
                $_SESSION['error'] = "Gagal menyimpan transaksi";
            }
        }
        
        // Ambil list produk untuk dropdown
        $stmt_produk = $produk->readAll();
        // Ubah ke array agar bisa di-loop di view
        $produkList = $stmt_produk->fetchAll(PDO::FETCH_ASSOC);
        include '../views/transaksi/create.php';
        break;
        
    case 'delete':
        if(isset($_GET['id'])) {
            $transaksi->id_transaksi = $_GET['id'];
            
            // Opsional: Kembalikan stok sebelum hapus (logic complex, skip dulu)
            
            if($transaksi->delete()) {
                $_SESSION['success'] = "Transaksi berhasil dihapus";
            } else {
                $_SESSION['error'] = "Gagal menghapus transaksi";
            }
        }
        header("Location: TransaksiController.php");
        exit();
        
    case 'cetak_laporan':
        // Logika laporan
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
        
        $stmt = $transaksi->readLaporan($start_date, $end_date);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        include '../views/transaksi/cetak_laporan.php'; // Pastikan file view ini ada, atau gunakan laporan.php
        break;
        
    default:
        $stmt = $transaksi->readAll();
        include '../views/transaksi/index.php';
        break;
}
?>