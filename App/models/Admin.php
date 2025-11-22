<?php
class Admin {
    private $conn;
    // PERBAIKAN 1: Nama tabel disesuaikan dengan database Anda (user)
    private $table = "user";

    public $id;
    public $username;
    public $nama_lengkap;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fungsi Cek Login
    public function login($username, $password) {
        // PERBAIKAN 2: Hapus ', role' dari query SELECT karena kolomnya tidak ada
        $query = "SELECT id, username, password, nama_lengkap 
                  FROM " . $this->table . " 
                  WHERE username = :username LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitasi input
        $username = htmlspecialchars(strip_tags($username));
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Cek Password (Hash)
            if(password_verify($password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->nama_lengkap = $row['nama_lengkap'] ?? 'Admin';
                
                // PERBAIKAN 3: Set role manual jadi 'admin' agar sistem tetap jalan
                $this->role = 'admin';
                
                return true;
            }
        }
        return false;
    }
}
?>