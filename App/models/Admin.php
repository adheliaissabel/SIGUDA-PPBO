<?php
class Admin {
    private $conn;
    private $table = "users";

    public $id;
    public $username;
    public $password;
    public $nama_lengkap;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Method untuk Login
    public function login($username, $password) {
        $query = "SELECT id, username, password, nama_lengkap, role 
                  FROM " . $this->table . " 
                  WHERE username = :username LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Verifikasi password hash
            if(password_verify($password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->nama_lengkap = $row['nama_lengkap'];
                $this->role = $row['role'];
                return true;
            }
        }
        return false;
    }

    // Method untuk Tambah Admin Baru
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET username=:username, password=:password, 
                      nama_lengkap=:nama_lengkap, role=:role";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitisasi input
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->role = htmlspecialchars(strip_tags($this->role));
        
        // Hash password sebelum disimpan
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':nama_lengkap', $this->nama_lengkap);
        $stmt->bindParam(':role', $this->role);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Method untuk Update Admin
    public function update() {
        // Query dasar
        $query = "UPDATE " . $this->table . " 
                  SET username=:username, nama_lengkap=:nama_lengkap, role=:role";
        
        // Jika password diisi, update password juga
        if(!empty($this->password)) {
            $query .= ", password=:password";
        }
        
        $query .= " WHERE id=:id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->nama_lengkap = htmlspecialchars(strip_tags($this->nama_lengkap));
        $this->role = htmlspecialchars(strip_tags($this->role));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':nama_lengkap', $this->nama_lengkap);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':id', $this->id);
        
        // Bind password baru jika ada
        if(!empty($this->password)) {
            $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashed_password);
        }

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Method untuk Hapus Admin
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>