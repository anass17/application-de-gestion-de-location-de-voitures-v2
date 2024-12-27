<?php

class RentalContract {
    private $conn;
    private User $user;

    // RentalContract properties
    private $id;
    private $car_id;
    private $rental_date;
    private $return_date;
    private $total_amount;
    private $user_id;

    public function __construct($conn, User $user) {
        $this->conn = $conn;
        $this->user = $user;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getCarId() {
        return $this->car_id;
    }

    public function getRentalDate() {
        return $this->rental_date;
    }

    public function getReturnDate() {
        return $this->return_date;
    }

    public function getTotalAmount() {
        return $this->total_amount;
    }

    public function getUserId() {
        return $this->user_id;
    }

    // Setters
    public function setCarId($car_id) {
        $this->car_id = $car_id;
    }

    public function setRentalDate($rental_date) {
        $this->rental_date = $rental_date;
    }

    public function setReturnDate($return_date) {
        $this->return_date = $return_date;
    }

    public function setTotalAmount($total_amount) {
        $this->total_amount = $total_amount;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }
    public function setId($id) {
        $this->id = $id;
    }

    // Create a new rental contract
    public function create() {
        $sql = "INSERT INTO rentalcontracts (car_id, rental_date, return_date, total_amount, ID_user) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $this->car_id,
            $this->rental_date,
            $this->return_date,
            $this->total_amount,
            $this->user->getId()
        ]);
    }

    // Read rental contract by ID
    public function read($id) {
        $sql = "SELECT * FROM rentalcontracts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 1) {
            $contract = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->setProperties($contract);
            return $contract;
        }
        return null;
    }

    // Update rental contract
    public function update() {
        if (!$this->user->isAdmin()) {
            return "You don't have permission to view cars.";
        }
        $sql = "UPDATE rentalcontracts SET car_id = ?, rental_date = ?, return_date = ?, total_amount = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $this->car_id,
            $this->rental_date,
            $this->return_date,
            $this->total_amount,
            $this->id
        ]);
    }

    // Delete rental contract
    public function delete() {
        if (!$this->user->isAdmin()) {
            return "You don't have permission to view cars.";
        }
        $sql = "DELETE FROM rentalcontracts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    // Set properties from a database row
    private function setProperties($contract) {
        $this->id = $contract['id'];
        $this->car_id = $contract['car_id'];
        $this->rental_date = $contract['rental_date'];
        $this->return_date = $contract['return_date'];
        $this->total_amount = $contract['total_amount'];
        $this->user_id = $contract['ID_user'];
    }

    // Fetch all rental contracts
    public function fetchAll() {
        $sql = "SELECT * FROM rentalcontracts JOIN users ON rentalcontracts.ID_user = users.id JOIN cars on rentalContracts.car_id = cars.id";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function fetchMyContracts() {
        $sql = "SELECT * FROM rentalcontracts JOIN users ON rentalcontracts.ID_user = users.id JOIN cars on rentalContracts.car_id = cars.id where users.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt -> execute(array(':id' => $this -> user -> getId()));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
