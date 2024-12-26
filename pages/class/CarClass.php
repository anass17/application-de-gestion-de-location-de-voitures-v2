<?php
class Car {
    private $conn;
    private $user;

    // Car properties
    private $id;
    private $make;
    private $model;
    private $year;
    private $license_plate;
    private $status;

    public function __construct($conn, User $user) {
        $this->conn = $conn;
        $this->user = $user; 
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getMake() {
        return $this->make;
    }

    public function getModel() {
        return $this->model;
    }

    public function getYear() {
        return $this->year;
    }

    public function getLicensePlate() {
        return $this->license_plate;
    }

    public function getStatus() {
        return $this->status;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setMake($make) {
        $this->make = $make;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function setYear($year) {
        $this->year = $year;
    }

    public function setLicensePlate($license_plate) {
        $this->license_plate = $license_plate;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    // Create a new car (admin only)
    public function create() {
        if (!$this->user->isAdmin()) {
            return "You don't have permission to add a car.";
        }

        $sql = "INSERT INTO cars (make, model, year, license_plate, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute([$this->make, $this->model, $this->year, $this->license_plate, $this->status])) {
            $this->id = $this->conn->lastInsertId(); // Set the ID of the newly created car
            return "Car created successfully.";
        }
        return "Error creating car.";
    }

    // Read all cars (admin only)
    public function readAll() {
        // if (!$this->user->isAdmin()) {
        //     return "You don't have permission to view cars.";
        // }

        $sql = "SELECT * FROM cars";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update a car's details (admin only)
    public function update() {
        if (!$this->user->isAdmin()) {
            return "You don't have permission to update a car.";
        }

        $sql = "UPDATE cars SET make = ?, model = ?, year = ?, license_plate = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$this->make, $this->model, $this->year, $this->license_plate, $this->status, $this->id]);
    }

    // Delete a car (admin only)
    public function delete() {
        if (!$this->user->isAdmin()) {
            return "You don't have permission to delete a car.";
        }

        $sql = "DELETE FROM cars WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    // Get car by ID
    public function getById($id) {
        $sql = "SELECT * FROM cars WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
