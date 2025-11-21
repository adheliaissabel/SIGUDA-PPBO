<?php
class Kategori {
    private $conn;
    private $table = "kategori";

    public $id_kategori; // Ganti $id menjadi $id_kategori
    public $nama_kategori;
    // public $deskripsi; // Kolom deskripsi tidak ada di database.sql

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        // Hapus kolom 'deskripsi'
        $query = "INSERT INTO " . $this->table . " 
                  SET nama_kategori=:nama_kategori"; // Hapus deskripsi=:deskripsi
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nama_kategori', $this->nama_kategori);
        // $stmt->bindParam(':deskripsi', $this->deskripsi); // Hapus bindParam

        return $stmt->execute();
    }

    public function readAll() {
        // Ganti 'id' menjadi 'id_kategori' dan hapus kolom yang tidak ada
        $query = "SELECT id_kategori, nama_kategori 
                  FROM " . $this->table . " ORDER BY nama_kategori ASC"; 
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        // Ganti 'id' menjadi 'id_kategori' dan hapus kolom yang tidak ada
        $query = "SELECT id_kategori, nama_kategori 
                  FROM " . $this->table . " WHERE id_kategori = :id_kategori LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $this->id_kategori); // Ganti :id menjadi :id_kategori
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row) {
            $this->id_kategori = $row['id_kategori']; // Tambahkan inisialisasi id_kategori
            $this->nama_kategori = $row['nama_kategori'];
            // $this->deskripsi = $row['deskripsi']; // Hapus
            return true;
        }
        return false;
    }

    public function update() {
        // Ganti 'id' menjadi 'id_kategori' dan hapus kolom 'deskripsi'
        $query = "UPDATE " . $this->table . " 
                  SET nama_kategori=:nama_kategori 
                  WHERE id_kategori=:id_kategori"; // Hapus deskripsi=:deskripsi
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nama_kategori', $this->nama_kategori);
        // $stmt->bindParam(':deskripsi', $this->deskripsi); // Hapus
        $stmt->bindParam(':id_kategori', $this->id_kategori); // Ganti :id menjadi :id_kategori

        return $stmt->execute();
    }

    public function delete() {
        // Ganti 'id' menjadi 'id_kategori'
        $query = "DELETE FROM " . $this->table . " WHERE id_kategori = :id_kategori";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $this->id_kategori); // Ganti :id menjadi :id_kategori
        return $stmt->execute();
    }

    public function countProduk() {
        // Kolom foreign key di produk adalah id_kategori
        $query = "SELECT COUNT(*) as total FROM produk WHERE id_kategori = :id_kategori"; // Ganti kategori_id menjadi id_kategori
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_kategori', $this->id_kategori); // Ganti :id menjadi :id_kategori
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>