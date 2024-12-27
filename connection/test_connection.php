<?php

include 'db.php';
require_once '../auth/UserClass.php';

require_once '../pages/class/RentalcontractClass.php';

$db = new Database();


$conn = $db->connect();


if ($conn) {
    echo "Connection successful!";
} else {
    echo "Connection failed!";
}

// Assuming we have a logged-in user
$user = new User($conn); // Assume the user is authenticated and the connection is $conn
$user->fetchById(2); 
// / Create a user instance

// Create a RentalContract instance
$rentalContract = new RentalContract($conn, $user);
// Set properties for the rental contract
// $rentalContract->setCarId(5);
// $rentalContract->setRentalDate('2024-12-26');
// $rentalContract->setReturnDate('2025-01-02');
// $rentalContract->setTotalAmount(500.00);
// Save the rental contract to the database

// if ($rentalContract->create()) {
//     echo "Rental contract created successfully.";
// } else {
//     echo "Failed to create rental contract.";
// }


$rentalContract->setCarId(5);
$rentalContract->setRentalDate('2024-12-26');
$rentalContract->setReturnDate('2025-01-02');
$rentalContract->setTotalAmount(1500.00);
$rentalContract->setId(8);

echo $rentalContract->update() ;
if ($rentalContract->update()) {

    echo "Rental contract updated successfully.";
} else {
    echo "Failed to create updater contract.";
}









// $sql = "DELETE FROM rentalcontracts WHERE id = ?";
// $stmt = $conn->prepare($sql);
//  echo $stmt->execute([6]);

// echo $stmt; // Outputs: 1