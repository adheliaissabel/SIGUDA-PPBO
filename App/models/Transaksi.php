<?php
class Transaksi {
    private $conn;
    private $table = "transaksi";

    public $id_transaksi;
    public $id_produk;
    public $jenis_transaksi;
    public $jumlah;
    public $tanggal;
    public $keterangan;
    public $kode_transaksi; // Opsional jika sudah ditambahkan di DB

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        // Query sesuaikan dengan kolom database.sql
        $query = "INSERT INTO " . $this->table . " 
                  SET id_produk=:id_produk, jenis_transaksi=:jenis_transaksi, 
                      jumlah=:jumlah, tanggal=:tanggal, keterangan=:keterangan";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_produk', $this->id_produk);
        $stmt->bindParam(':jenis_transaksi', $this->jenis_transaksi);
        $stmt->bindParam(':jumlah', $this->jumlah);
        $stmt->bindParam(':tanggal', $this->tanggal);
        $stmt->bindParam(':keterangan', $this->keterangan);

        return $stmt->execute();
    }

    public function readAll() {
        // Join dengan tabel produk untuk ambil nama produk
        $query = "SELECT t.*, p.nama_produk, p.ukuran 
                  FROM " . $this->table . " t
                  JOIN produk p ON t.id_produk = p.id_produk
                  ORDER BY t.tanggal DESC, t.id_transaksi DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readLaporan($start_date, $end_date) {
        $query = "SELECT t.*, p.nama_produk, p.ukuran, k.nama_kategori
                  FROM " . $this->table . " t
                  JOIN produk p ON t.id_produk = p.id_produk
                  JOIN kategori k ON p.id_kategori = k.id_kategori
                  WHERE t.tanggal BETWEEN :start AND :end
                  ORDER BY t.tanggal ASC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':start', $start_date);
        $stmt->bindParam(':end', $end_date);
        $stmt->execute();
        return $stmt;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id_transaksi = :id_transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_transaksi', $this->id_transaksi);
        return $stmt->execute();
    }
}
?>