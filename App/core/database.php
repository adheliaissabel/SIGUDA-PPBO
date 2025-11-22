<?php
class Database {
    // Settingan Default (Localhost)
    private $host = "localhost";
    private $db_name = "gudang_fashion";
    private $username = "root";
    private $password = "mkjw4004"; 
    private $port = "3306";

    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // --- LOGIKA KONEKSI RAILWAY (Sesuai Screenshot Anda) ---
        
        // Cek apakah ada variabel DB_HOST (Sesuai dashboard App Service Anda)
        if (getenv('DB_HOST')) {
            $this->host = getenv('DB_HOST');
            $this->db_name = getenv('DB_NAME');
            $this->username = getenv('DB_USER');
            $this->password = getenv('DB_PASSWORD');
            $this->port = getenv('DB_PORT');
        } 
        // Cek variabel cadangan (jika pakai standar Railway lain)
        elseif (getenv('MYSQLHOST')) {
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
            echo "Koneksi Database Gagal: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>