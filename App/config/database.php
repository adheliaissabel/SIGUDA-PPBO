<?php
class Database {
    // Sesuaikan dengan setting Railway
    private $host = "localhost"; 
    private $db_name = "gudang_fashion";
    private $username = "root";
    private $password = "";

    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // Cek Environment Variable Railway (Otomatis)
        if (getenv('MYSQLHOST')) {
            $this->host = getenv('MYSQLHOST');
            $this->db_name = getenv('MYSQLDATABASE');
            $this->username = getenv('MYSQLUSER');
            $this->password = getenv('MYSQLPASSWORD');
            $port = getenv('MYSQLPORT');
        } else {
            $port = 3306;
        }

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";port=" . $port . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>