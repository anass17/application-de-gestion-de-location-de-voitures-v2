<?php


class User {
    private $conn;

    // User properties
    private $id;
    private $username;
    private $password;
    private $email;
    private $created_at;
    private $role;
    private $phone;
    private $address;
    public $error;

    public function __construct($conn) {
        $this->conn = $conn;
    }


 // Getters
 public function getId() {
    return $this->id;
}

public function getUsername() {
    return $this->username;
}

public function getEmail() {
    return $this->email;
}

public function getRole() {
    return $this->role;
}

public function getPhoneN() {
    return $this->phone;
}

public function getAddress() {
    return $this->address;
}

// Setters
public function setId($id) {
    $this->id = $id;
}

public function setUsername($username) {
    $this->username = $username;
}

public function setEmail($email) {
    $this->email = $email;
}

public function setRole($role) {
    $this->role = $role;
}

public function setPhoneN($phone) {
    $this->phone = $phone;
}

public function setAddress($address) {
    $this->address = $address;
}

// Check if the user has admin privileges
public function isAdmin() {
    return $this->role === 'admin';
}
    // Create a new user
    public function register($username, $email, $password) {
        $this -> username = $username;
        $this -> email = $email;
        $this -> password = $password;

        if ($this->userExists($this -> username, $this -> email)) {
            $this -> error = "Username or email already exists";
            return false;
        }

        $hashedPassword = password_hash($this -> password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password, role, phoneN, Address) VALUES (?, ?, ?, 'admin', ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt->execute([$this->username, $this->email, $hashedPassword, $this->phone, $this->address])) {
            $this->id = $this->conn->lastInsertId(); // Set the ID of the newly created user
            return true;
        }

        $this -> error = "Error registering user";
        return false;
    }

    // Login method
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                $_SESSION["id"] = $user['id'];
                return [
                    'status' => true,
                    'user' => [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                    ]
                ];
            }
        }
        return ['status' => false, 'message' => 'Invalid username or password.'];
    }


    // Check if a user exists
    private function userExists($username, $email) {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $email]);
        return $stmt->rowCount() > 0;
    }


    // Update user details
    public function update() {
        $sql = "UPDATE users SET username = ?, email = ?, role = ?, phoneN = ?, Address = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$this->username, $this->email, $this->role, $this->phone, $this->address, $this->id]);
    }

    // Delete user
    public function delete() {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$this->id]);
    }

    // Set user properties from a database row
    private function setUserProperties($user) {
        $this->id = $user['id'];
        $this->username = $user['username'];
        $this->password = $user['password'];
        $this->email = $user['email'];
        $this->created_at = $user['created_at'];
        $this->role = $user['role'];
        $this->phone = $user['phoneN'];
        $this->address = $user['Address'];
    }
    // Fetch user by ID
    public function fetchById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->setUserProperties($user);
            return $user;
        }
        return null;
    }
    
}


