<?php

use Dotenv\Dotenv;

class Database {
    private $host;
    private $user;
    private $password;
    private $dbname;
    public $conn;

    public function __construct() {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // Assign environment variables to class properties
        $this->host = $_ENV['DB_HOST'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dbname = $_ENV['DB_NAME'];
    }

    // Method to connect to the database using PDO
    public function connect() {
        try {
            // Set the Data Source Name (DSN)
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            
            $this->conn = new PDO($dsn, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $this->conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}
