<?php
    session_start();

    if (!isset($_SESSION['id'])) {
        header("Location: auth/login.php");
        exit();
    }

    require_once 'vendor/autoload.php';
    require 'connection/db.php';
    require 'auth/UserClass.php';

    $conn = (new Database) -> connect();

    $user = new User($conn);

    $user -> fetchById($_SESSION['id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar Section -->
    <nav class="bg-blue-600 text-white p-4 shadow">
        <ul class="flex justify-around">
            <li><a href="pages/view_clients.php" class="hover:text-gray-200">View Clients</a></li>
            <li><a href="pages/add_car.php" class="hover:text-gray-200">Add Cars</a></li>
            <li><a href="pages/view_cars.php" class="hover:text-gray-200">View Cars</a></li>
            <li><a href="pages/add_rental_contract.php" class="hover:text-gray-200">Add Rental Contract</a></li>
            <li><a href="pages/view_rental_contracts.php" class="hover:text-gray-200">View Rental Contracts</a></li>
            <li><a href="auth/logout.php" class="hover:text-gray-200">Logout</a></li>
        </ul>
    </nav>

    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold text-gray-700 text-center">Welcome, <?php echo htmlspecialchars($user -> getUsername()); ?>!</h1>
        <p class="text-center mt-4">You are now logged in. Use the navigation bar to explore the application.</p>
    </div>
</body>
</html>
