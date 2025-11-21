<?php
class Database {
    // Sesuaikan dengan setting XAMPP/Laragon Anda
    private $host = "localhost";
    private $db_name = "gudang_fashion";
    private $username = "root";
    private $password = "mkjw4004"; // Kosongkan jika pakai XAMPP default

    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            // Setting error mode agar jika query salah, muncul pesan error jelas
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>