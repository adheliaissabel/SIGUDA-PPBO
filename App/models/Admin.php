<?php
class Admin {
    private $conn;
    // Nama tabel disesuaikan dengan database Anda (user)
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
        // Hapus ', role' dari query SELECT karena kolomnya tidak ada
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
            
            // PERBAIKAN UTAMA:
            // Cek Password Biasa (Tanpa Hash)
            // Membandingkan langsung inputan 'admin123' dengan database 'admin123'
            if($password == $row['password']) {
                
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->nama_lengkap = $row['nama_lengkap'] ?? 'Admin';
                
                // Set role manual jadi 'admin' agar sistem tetap jalan
                $this->role = 'admin';
                
                return true;
            }
        }
        return false;
    }
}
?>