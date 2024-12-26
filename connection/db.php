<?php
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '1234';
    private $dbname = 'your_database_name';
    public $conn;

    public function connect() {
        try {
            // Set the DSN (Data Source Name) for PDO connection
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            // Create PDO instance
            $this->conn = new PDO($dsn, $this->user, $this->password);
            // Set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
        
        return $this->conn;
    }
}
?>
