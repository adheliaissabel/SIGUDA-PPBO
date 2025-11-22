<?php
class Database {
    // Settingan Default (Localhost)
    private $host = "localhost";
    private $db_name = "gudang_fashion";
    private $username = "root";
    private $password = ""; 
    private $port = "3306";

    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // --- LOGIKA KONEKSI RAILWAY ---
        // Mengambil settingan otomatis dari server Railway
        if (getenv('MYSQLHOST')) {
            $this->host = getenv('MYSQLHOST');
            $this->db_name = getenv('MYSQLDATABASE');
            $this->username = getenv('MYSQLUSER');
            $this->password = getenv('MYSQLPASSWORD');
            $this->port = getenv('MYSQLPORT');
        }

        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name;
            
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            // Jika error, tampilkan pesannya
            echo "Gagal Konek Database: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>